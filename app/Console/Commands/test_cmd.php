<?php

namespace App\Console\Commands;

use App\Models\Record;
use App\Sources\AudioPlayer\AudioPlayer;
use App\Sources\AudioPlayer\Players\Player;
use App\Sources\AudioRecording\Records\Recorder;
use Illuminate\Console\Command;
use function React\Promise\Stream\first;

class test_cmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = public_path('files\audio\template.mp3');
        $ffmpeg_raw_audio_data_8000    = "ffmpeg -i \"$path\" -ac 1 -filter:a aresample=1500 -map 0:a -c:a pcm_s16le -f data -";

//        RAW DATA
        $raw_audio_data = Recorder::shell_exec_RecordType($ffmpeg_raw_audio_data_8000);
        dump('---------------------------');
        dump($raw_audio_data);

//        HEXA
        $hexa_audio_data =  bin2hex($raw_audio_data);
        dump('---------------------------');
        dump($hexa_audio_data);
        dump('---------------------------');

//        ARRAY BYTES
        $array = array_map('hexdec', str_split($hexa_audio_data, 2));
        dd($array);
        dump('---------------------------');

//        $record = (new Record())->latest('id')->first();
//        (new Player())->streamVlc($record);
    }
}
