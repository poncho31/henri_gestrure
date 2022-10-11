<?php
namespace App\Console;

use App\Sources\AudioRecording\AudioRecording;
use Illuminate\Console\Command;

class Audio_CMD extends Command
{
    protected $signature = 'audio {action?} {parameter1?} {parameter2?}';
    protected $description = 'Audio tools : read / record';
    private AudioRecording $audio;

    public function __construct()
    {
        parent::__construct();
        $this->audio = new AudioRecording(getmypid());
    }

    public function handle(): void
    {
        $parameter1 = $this->argument('parameter1');
        $parameter2 = $this->argument('parameter2');
        switch ($this->argument('action')){
            case 'play':
                $this->audio->readAudio();
                break;
            case 'record':
                $recordType   = $parameter1 ?? 'proc_open';
                $fileNameTest = $parameter2 ?? public_path('files\audio') . '\TEST_'.date('Ymd_H_i_s').".mp3";
                $this->audio->recordAudio($fileNameTest, $recordType, true);
                break;
            case 'stop-record':
                $this->audio->killProcess($parameter1);
                break;
        }
    }
}
