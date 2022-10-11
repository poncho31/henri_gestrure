<?php

namespace App\Http\Livewire;

use App\Events\BroadcastEventToUserNow as Event;
use App\Models\Record;
use App\Sources\AudioPlayer\Players\Player;
use App\Sources\AudioRecording\AudioRecording;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecordLivewire extends Component
{
    public bool   $isRecord = false;
    public        $processId = 0;
    public Record $recordModel;
    public string $output = "";

    private AudioRecording $audioRecording;

//    protected $listeners = ['echo:event.recordAudio,BroadcastEventToUserNow' => 'recordAudio'];

// TODO : faire du recordLivewire à la fois un controller / un livewire et un GreateModel
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->audioRecording = new AudioRecording(getmypid());
        $this->recordModel    = new Record();
    }


    protected function getListeners(): array
    {
        return [
            "user.{$this->recordModel->id}" => '?'
        ];
    }

    protected $rules = [
        'recordModel.category' => 'required|string',
        'recordModel.name'     => 'required|string',
    ];

    public function mount(?Record $record)
    {
        $record = $record === null ? $this->recordModel : $record;
        $this->recordModel= $record;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.recordLivewire');
    }

    public function recordAudio(Request $request): void
    {
        ob_start();
//        $this->emit('user.'.Auth::id(),'recordAudio' );
        $this->recordModel->fullpath = public_path('files\\audio\\'). "RECORD_{$this->recordModel->id}_".(date('h_i_s')).".mp3";
        $this->recordModel = $this->audioRecording->recordAudio($this->recordModel);
        $this->output .= json_encode($this->recordModel);
        $this->streamAudio($type='vlc');
        ob_end_clean();
    }

    public function streamAudio(string $type='vlc'){ // or streamAudio ?

//        $url = "http://localhost:8080/stream/$record->name";
        if($type=='vlc'){
            (new Player())->streamVlc($this->recordModel);
        }
        else{
            return null;
        }
    }

    public function stopAudio(Request $request): void
    {
        ob_start();
        $this->audioRecording->stopRecord($this->recordModel);
        $this->recordModel->isRunning = false;
        $this->recordModel->save();
        $this->output .= dump("Process {$this->recordModel->processId} arrêtés");
        ob_end_clean();
    }
}
