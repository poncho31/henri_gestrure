{{--{{dd($record)}}--}}
<div class="record table-container" data-id="{{$recordModel->id}}"  >
    <table class="table ">
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr id="recorderFirstLine">
            {{--    Nom du record--}}
            <td id="ZoneTitle" colspan="5">
                <input type="text"
                       value="{{$recordModel->name }}"
                       name="recordCreate{{$recordModel->id}}"
                       class="input is-primary is-small text-center"
                    {{--                           style="width: 35%; margin: 5px;"--}}
                >
            </td>
            <td colspan="3"><button wire:click="stopAudio()">Process : {{$recordModel->processId}}</button></td>
            <td colspan="3" title="catégorie"><input wire:model="recordModel.category" type="text" value="{{$recordModel->category}}"></td>
            <td colspan="3" style="overflow: hidden">
                {{$recordModel->path }}
            </td>
            <td colspan="2" style="overflow: auto">{{$recordModel->processName}}</td>
            <td colspan="3" style="overflow: auto">{{$recordModel->deviceName}}</td>
        </tr>
        <tr id="recorderSecondLine">
            {{--   RECORD --}}
            <td id="ZoneRecord" colspan="2">
                {{--    RUN --}}
                @if(!$recordModel->isRunning)
                    <button  id="runRecord{{$recordModel->id}}"
                             data-id="{{$recordModel->id}}"
                             data-url="{{url('recorder/run/'.$recordModel->id)}}"
                             class="recorder runRecord button is-success h-16"
                             wire:click="recordAudio()"
                    >
                        Play Record
                    </button>
                @else
                    {{--    STOP--}}
                    <button id="stopRecord{{$recordModel->id}}"
                            data-id="{{$recordModel->id}}"
                            data-url="{{url('recorder/stop/'.$recordModel->id)}}"
                            class="recorder stopRecord button is-danger h-16"
                            wire:click="stopAudio()"
                    >
                        Stop record {{$recordModel->processId ?? '--Erreur--'}}
                    </button>
                @endif
            </td>
            {{--            INFOS / ERRROR--}}
            <td id="ZoneInfo" colspan="1">
                 <span id="recordInfo{{$recordModel->id}}" class="icon has-text-info" title="informaition">
                   <i class="fa fa-info-circle"></i>
                 </span>

                <span id="recordError{{$recordModel->id}}" class="icon has-text-warning" title="Warning">
                   <i class="fa fa-exclamation-triangle"></i>
                 </span>
            </td>

            {{--    AUDIO PLAYER--}}
            URL : "http://localhost:8080/stream/{{$recordModel->name}}"
            <td id="ZoneAudioPlayer" colspan="4">
                <span id="audioPlayer{{$recordModel->id}}" >
{{--                    @include('audioplayer')--}}
                    <div id="audio-player-container playRecord">
                        <audio controls>
                            <source src="http://localhost:8080/stream/{{$recordModel->name}}" type="audio/mp3">
                            <source src="http://localhost:8080/stream/{{$recordModel->name}}" type="audio/ogg">
{{--                            {{ asset('files/audio').'/' .( $recordModel->name ??'template.mp3')}}--}}
                        </audio>
                    </div>
                </span>
            </td>

            {{-- GRAPHE AUDIO --}}
            <td id="ZoneGraphePlayer" colspan="13" rowspan="2">
                <span id="audioGraph{{$recordModel->id}}"  >
                    ZONE GRAPHE PLAYER
                </span>
            </td>
        </tr>
        {{--        OUTPUT--}}
        <tr id="recorderThirdLine">
            <td colspan="7" id="ZoneOutput">
                <div id="output{{$recordModel->id}}">
                    ZONE OUTPUT N° {{$recordModel->id}}
                    {{$output}}
                </div>
            </td>
            <td colspan="13" ></td>
        </tr>
    </table>


</div>
@push('js')
    <script>
        // $('.runRecord').on('click', function(){
        //     let emit =window.livewire.emit('event.recordAudio');
        //     console.log(emit)
        // })
    </script>
@endpush
@push('css')
    <style>
        .table-container{
        }
        td{
            width: 5vw;
            /*min-width: 5vw;*/
            max-width: 5vw;
        }
        table{
            max-height: 150px;
        }

        #recorderFirstLine{
            height: {{$recordOption['bloc1']['max-height'] ?? '50px'}};
            min-height: {{$recordOption['bloc1']['max-height'] ?? '50px'}};
            max-height: {{$recordOption['bloc1']['max-height'] ?? '50px'}};
            color: white;
            background-color: #2b74b1;
        }
        #recorderSecondLine{
            height: {{$recordOption['bloc2']['max-height'] ?? '100px'}};
            min-height: {{$recordOption['bloc2']['max-height'] ?? '100px'}};
            max-height: {{$recordOption['bloc2']['max-height'] ?? '100px'}};
        }
        #recorderThirdLine{
            height: {{$recordOption['bloc3']['max-height'] ?? '100px'}};
            min-height: {{$recordOption['bloc3']['max-height'] ?? '100px'}};
            max-height: {{$recordOption['bloc3']['max-height'] ?? '100px'}};
        }

        #ZoneAudioPlayer{
            color: white;
            background-color: #4d83db;
        }
        #ZoneGraphePlayer{
            color: white;
            background-color: #00b89c;
        }

        #ZoneRecord{
            color: white;
            background-color: #00d1b2;
        }

        #ZoneTitle{

        }

        #ZoneInfo{
            color: white;
            background-color: #defffa;
        }

        #ZoneOutput{
            /*height:auto !important;*/
            overflow: scroll;
            color: white;
            background-color: #2959b3;
            min-height: 100px !important;
            max-width: 35vw;
            max-height: 100px !important;
        }
        #ZoneOutput div{
            font-size: 0.6em;
            min-height: 100px !important;
            max-width: 35vw;
            max-height: 100px !important;
        }

        .display{
            display: none;
        }
        /*button{*/
        /*    margin: 10px 5px;*/
        /*    border: 1px solid hsl(0, 0%, 70%);*/
        /*    color: white;*/
        /*    text-shadow: 1px 1px 0px #0a0a0a ;*/
        /*}*/
        /*button:first-child{*/
        /*    margin-left: 10px;*/
        /*}*/
        /*button:last-child{*/
        /*    margin-right: 10px;*/
        /*}*/

        /*tr{*/
        /*    background-color: hsl(0, 0%, 96%);*/
        /*}*/

        /*.meta{*/
        /*    !*display: none;*!*/
        /*}*/



        /*.record table{*/
        /*    !*min-width: 50%;*!*/
        /*    border: 1px solid hsl(0, 0%, 70%);*/
        /*    !*margin-left: 25vw*!*/
        /*    background-color: hsl(0, 0%, 70%);*/
        /*}*/
        /*td#title{*/
        /*    width: 100%;*/
        /*    background-color: hsl(0, 0%, 85%);*/
        /*    text-align: center;*/
        /*    border: 1px solid hsl(0, 0%, 70%);*/
        /*    font-weight: bolder;*/
        /*    color: white;*/
        /*    text-shadow: 1px 1px 0px #0a0a0a ;*/
        /*}*/
    </style>
@endpush
