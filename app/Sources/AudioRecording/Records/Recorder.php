<?php

namespace App\Sources\AudioRecording\Records;


use App\Models\Record;
use App\Sources\AudioRecording\Commands\PowershellCommand;
use App\Sources\Utils\Converter;

class Recorder
{

    public static function proc_open_RecordType(Record $record, $isInBackground = true, $debug = false): Record
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

        // 1. Process of the  ENCODING DRIVER
        if($record->processName == 'ffmpeg'){
            // GET FFMPEG PROCESS
            $execution->cmdFFMPEG = (new PowershellCommand('ProcessName, Id, CPU', 'ProcessName', 'like', '*ffmpeg*'));
            $execution->cmd = "powershell ". $execution->cmdFFMPEG->create('Get-Process');

            $record->processId = json_decode(shell_exec($execution->cmd) ?? '', true)['Id']?? 0;
        }
        $record->isRunning = $record->processId > 0;
        dump('1. PROCESS (FFMPEG) REAL PID : '. $record->processId??'NONE');

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




    public static function popen_RecordType($cmd, $processId = null): null|string
    {
        $proc = popen($cmd, 'r');
        $data = '';
        while (!feof($proc)) {
            $echo = fread($proc, 4096);
            echo $echo ; // ."\r\n";

            dump(pclose($proc));
            $data .=$echo ."\r\n";
        }
        $end = pclose($proc);

//        dd("yeeeep");
        return $data;
    }

    public static function pclose_RecordType($cmd, $processId = null): null|string
    {
        $proc = pclose($popen=popen("start $cmd", 'r'));

        echo $proc ;
        return '';
    }

    public static function shell_exec_RecordType($cmd, $processId = null): bool|string|null
    {
        $output = shell_exec($cmd);
        return $output;
    }

    public static function exec_RecordType($cmd, $processId = null)
    {
        $exec = exec($cmd, $output);
        echo $exec;
        return $output;
    }

    public static function record_cmd(Record $record, string $cmdType = 'ffmpeg'): Record
    {
        switch ($record->processName = $cmdType){
            case 'ffmpeg':
            default      :
                $record->command="powershell ffmpeg -f dshow -i audio='$record->deviceName' $record->fullpath -f ffmetadata $record->path\METADATA$record->name.txt 2>&1";
                // Voir fsync() ?
                break;

            case 'ffmpeg-stream-to-vlc':
                $record->command="powershell -re  -i input -f rtsp -rtsp_transport tcp rtsp://172.28.107.100:8090/live.sdp 2>&1";
                break;
        }
        return $record;
    }

    public static function Conversion($filepathFrom, $filepathTo = null): bool|string|null
    {
        return shell_exec("ffmpeg -i $filepathFrom -preset slower -crf ".$filepathTo??$filepathFrom);
    }

    public static function ChangeTitle($filepathFrom, $filepathTo = null): bool|string|null
    {
        return shell_exec("ffmpeg
                                        -i $filepathFrom
                                        -map_metadata -1
                                        -metadata title='My Title'
                                        -c:v copy
                                        -c:a copy ". $filepathTo??$filepathFrom
        );
    }

    public static function StopRecordByProcessId($processId): ?string
    {
        $adminCmd = "start-process powershell -Verb RunAs";
        dump((shell_exec($adminCmd)));
        dump(shell_exec("TASKKILL /IM $processId /F"));
        return "";
    }
}
