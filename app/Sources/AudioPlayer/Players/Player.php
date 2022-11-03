<?php

namespace App\Sources\AudioPlayer\Players;

use App\Models\Record;
use App\Sources\AudioRecording\Commands\PowershellCommand;
use App\Sources\AudioRecording\Records\Recorder;
use App\Sources\Utils\Converter;

class Player
{
    public function streamVlc(Record $record): Record
    {

        dump("localhost:8080/stream/$record->id");
        // basename($record->fullpath) alors une liste,  si basename($record->path) alors lis le dossier
//        $cmd = "vlc -vvv $record->fullpath --sout='#transcode{vcodec=none,acodec=mp3,vb=800,ab=128}: http{access=http,mux=mp3,dst=localhost:8080/stream/$record->id}' ";
        $record->command = "vlc $record->fullpath --sout=\"#transcode{vcodec=none,acodec=mp3,ab=128,channels=2,samplerate=44100}:http{mux=mp3,dst=localhost:8080/stream/$record->id}\" --sout-keep --loop";
//        $record->command = $cmd;
        $record->options =['execution'=> ['vlc'=>['cmd', $record->command]]];
        $record = self::proc_open_PlayerType($record);
        $record->update();
        return $record;
    }
    public static function proc_open_PlayerType(Record $record, $isInBackground = true, $debug = false): Record
    {
        $execution = new \stdClass();
        $execution->desciptiorSpec = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];
        $execution->isInBackground = $isInBackground ? '/B' : '';

        // START CMD
        $execution->proc = proc_open("start $execution->isInBackground  $record->command", $execution->desciptiorSpec, $execution->pipes, dirname(__FILE__), null);

        $execution->cmdGetProcess = (new PowershellCommand('ProcessName, Id, CPU', 'ProcessName', 'like', '*vlc*'));
        $execution->cmd = "powershell ". $execution->cmdGetProcess->create('Get-Process');
//        $record->processId = json_decode(shell_exec($execution->cmd) ?? '', true)['Id']?? 0;
//        $record->isRunning = $record->processId > 0;

        dump('1. FFMPEG REAL PID 1: '. $record->processId??'NONE');

        // STATUT
        dump("2. PROC DETAILS STATUTS",$proc_details = proc_get_status($execution->proc));

        if($debug){
            // OUT PIPE 1
            dump( "2.1. STDOUT:", $stdout = stream_get_contents($execution->pipes[1]));
            fclose($execution->pipes[1]);

            // OUT PIPE 2
            dump("2.2. STDERR:", $stderr = stream_get_contents($execution->pipes[2]));
            fclose($execution->pipes[2]);
        }

        // CLOSE PROCESS
        dump('3. Exit code :', $exitCode = proc_close($execution->proc));

        // STOP RECORD
        dump("4. FOR KILL PROCESS :  taskkill -IM $record->processId /F");

        $optionsMerge = array_merge($record->options??[],['execution'=>Converter::loopToArray((array)$execution)]);
        $record->options = json_encode($optionsMerge);

        return $record;
    }

}
