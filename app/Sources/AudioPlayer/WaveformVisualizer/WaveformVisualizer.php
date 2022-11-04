<?php

namespace App\Sources\AudioPlayer\WaveformVisualizer;

use App\Sources\AudioRecording\Records\Recorder;

class WaveformVisualizer
{
    /**
     * Generate a peak audio wave form with 'audiowaveform' library
     * @param string $path Full path of the audio file
     * @return array|object version / channels / sample_rate / sample_rate_per_pixel / bits / length / data
     */
    public static function generate(string $path): array|object
    {
        chdir(app_path('Sources/AudioPlayer/WaveformVisualizer/AudioWaveform'));
        $audiowaveformJsonPath = storage_path("temp/".(basename($path)).".json");
        Recorder::shell_exec_RecordType("audiowaveform -i \"$path\" -o \"$audiowaveformJsonPath\" -z 256 -b 8");
        return json_decode(file_get_contents($audiowaveformJsonPath));
    }

    public function test(){

        $ffmpeg_image_audio_visualizer = "ffmpeg -i template.mp3 -lavfi showspectrumpic=s=1024x1024 template.png";
        $ffmpeg_raw_audio_data_8000    = "ffmpeg -i template.mp3 -ac 1 -filter:a aresample=8000 -map 0:a -c:a pcm_s16le -f data -";
        $raw_audio_data = Recorder::shell_exec_RecordType($ffmpeg_raw_audio_data_8000);
        $hexa_audio_data =  bin2hex($raw_audio_data);
        dd($hexa_audio_data);
    }
}
