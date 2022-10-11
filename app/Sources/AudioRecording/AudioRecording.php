<?php

namespace App\Sources\AudioRecording;

use App\Models\Record;
use App\Sources\AudioRecording\Devices\Devices;
use App\Sources\AudioRecording\Records\Recorder;

class AudioRecording
{

    private int $processId;

    public function __construct(int $processId){
        $this->processId = $processId;
    }


    /**
     * Enregistre l'entrée donnée et retourne l'id du processus en cours (par défaut l'entrée donnée est le microphone)
     * @param Record $record
     * @param string $type
     * @param bool $isInBackground
     * @param bool $debug
     * @return Record
     */
    public function recordAudio(Record $record, string $type='proc_open',bool $isInBackground = true, bool $debug = false): Record
    {
        // BEGIN : INIT
        dump("BEGIN RECORDING : ", $time=round(microtime(true), 4));
        $record->category = $record->category?? 'default';
        $record->path     = dirname($record->fullpath)!=''?dirname($record->fullpath):public_path('files\audio');
        $record->name     = basename($record->fullpath);
        $mkdir = file_exists($record->path) || mkdir($record->path, 0777, true);


        // 1. CHOIX DU PERIPHERIQUE AUDIO
        $record->deviceName = Devices::audio()['pnpdevice'][4] ?? 0;
        dump("NAME :" . $record->deviceName); // 'Microphone (ZOOM G Series)'

        // 2. CHOIX DU TYPE DE LA LIBRAIRIE D'ENREGISTREMENT (ffmpeg)
        $recordCommand = Recorder::record_cmd($record, 'ffmpeg');

        // 3. LANCEMENT DE L'ENREGISTREMENT
        if ($type=='proc_open'){
            // !! WORK !!
            $record = Recorder::proc_open_RecordType($record, $isInBackground, $debug);
        }
        elseif($type=='shell_exec'){
            Recorder::shell_exec_RecordType($recordCommand);
        }
        elseif($type=='popen'){
            Recorder::popen_RecordType($recordCommand);
        }
        elseif($type=='pclose'){
            Recorder::pclose_RecordType($recordCommand);
        }

        // END
        dump("END RECORDING : " . ($time=$time-round(microtime(true), 4))) . " s";
        $record->save();

        return $record;
    }

    public function readAudio(Record $record): void
    {
        dump("read audio");
        dump("GET PID : $record->processId");
        shell_exec("vlc -I dummy --play-and-stop $record->fullpath");// --playlist-enqueu
    }

    public function stopRecord(Record $record): ?string
    {
        return Recorder::StopRecordByProcessId($record->processId);
    }


}
