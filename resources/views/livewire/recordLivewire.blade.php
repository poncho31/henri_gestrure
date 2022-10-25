{{--{{dd($record)}}--}}
<div>



    <div class="gridRecorder">
{{--        NOM DE L'ENREGISTREMENT --}}
        <div class="firstRow name" id="ZonTitle">
            <label>
                <input
                    type="text"
                    value="{{$recordModel->name ?? 'Nom de l\'enregistrement' }}"
                    name="recordCreate{{$recordModel->id}}"
                    class="input is-primary is-small text-center"
                    style=""
                >
            </label>
        </div>
{{--        PROCESS--}}
        <div class="firstRow process" id="ZoneProcess">
            <button
                wire:click="stopAudio()"
                class="input is-primary is-small text-center"
            >
                Process : {{$recordModel->processId}}
            </button>
        </div>
{{--        CATEGORY--}}
        <div class="firstRow category" id="ZoneCategory">
            <label>
                <input
                    wire:model="recordModel.category"
                    type="text"
                    value="{{$recordModel->category ?? 'category'}}"
                    class="input is-primary is-small text-center"
                >
            </label>
        </div>
{{--        EXECUTION--}}
        <div class="firstRow execution" id="ZoneExecution">
            <label>
                <input
                    type="text"
                    value="{{$recordModel->options !== null ?json_encode($recordModel->options) : 'ececutions'}}"
                    class="input is-primary is-small text-center"
                >
            </label>
        </div>
{{--        PATH--}}
        <div class="firstRow path" id="ZonePath">
            <label>
                <input
                    type="text"
                    value="{{$recordModel->path ?? 'path' }}"
                    class="input is-primary is-small text-center"
                >
            </label>
        </div>
{{--        PROCESS--}}
        <div class="firstRow type" id="ZoneProcess">
            <label>
                <input
                    type="text"
                    value="{{$recordModel->processName ?? 'process' }}"
                    class="input is-primary is-small text-center"
                >
            </label>
        </div>
{{--        DEVICE--}}
        <div class="firstRow input1" id="ZoneDevice">
            <label>
                <input
                    type="text"
                    value="{{$recordModel->deviceName ?? 'device' }}"
                    class="input is-primary is-small text-center"
                >
            </label>
        </div>

{{--        RECORD--}}
        <div class="secondRow record" id="ZoneRecord" >
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
        </div>
{{--        INFOS--}}
        <div class="secondRow information" id="ZoneInfo">
             <span id="recordInfo{{$recordModel->id}}" class="icon has-text-info" title="informaition">
                 <i class="fa fa-info-circle"></i>
             </span>
            <span id="recordError{{$recordModel->id}}" class="icon has-text-warning" title="Warning">
                <i class="fa fa-exclamation-triangle"></i>
            </span>
        </div>
{{--        PLAYER--}}
        <div class="secondRow player" id="ZoneAudioPlayer">
                 <span  >
                     <div id="audio-player-container playRecord" >
                         <div class="audio">
                                 <h2>Sound Information</h2>
                                <div id="length">Duration:</div>
                                <div id="source">Source:</div>
                                <div id="status" style="color:red;">Status: Loading</div>
                                <hr>
                                <h2>Control Buttons</h2>
                                <button id="play">Play</button>
                                <button id="pause">Pause</button>
                                <button id="restart">Restart</button>
                                <hr>
                                <h2>Playing Information</h2>
                                <div id="currentTime">0</div>
                         </div>
                     </div>
                 </span>
        </div>
{{--        GRAPHE--}}
        <div class="secondRow graphPlayer">
             <span id="audioGraph{{$recordModel->id}}"  >
                 ZONE GRAPHE PLAYER
             </span>
        </div>
{{--        OUTPUT--}}
        <div class="thirdRow output" id="zo">
            <label for="output{{$recordModel->id}}"></label>
            <textarea
                id="output{{$recordModel->id}}"
                style="width: 100%; height: 100%"
            >
                        ZONE OUTPUT N° {{$recordModel->id}}
                {{$output}}
            </textarea>
        </div>
    </div>




{{--    TEST MODAL--}}
    <button class="js-modal-trigger" data-target="modal-js-example">
        Open JS example modal
    </button>
    <div id="modal-js-example" class="modal">
        <div class="modal-background"></div>

        <div class="modal-content">
            <div class="box">
                <p>Modal JS example</p>
                <!-- Your content -->
            </div>
        </div>

        <button class="modal-close is-large" aria-label="close"></button>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            // $('.modal').on()
            var audioElement = document.createElement('audio');
            $('.audio').on('click', function(){
                $.ajax({
                    url: '{{url('stream/audio')}}',
                    type: "POST",
                    success: function (data) {

                        audioElement.setAttribute('src', 'http://www.soundjay.com/misc/sounds/bell-ringing-01.mp3');

                        audioElement.addEventListener('ended', function() {
                            this.play();
                        }, false);
                        console.log(data)
                        $(this).pause();
                        $(this).setSrc(data);
                        $(this).load();
                        $(this).play();

                    }
                });
            })


            audioElement.addEventListener("canplay",function(){
                $("#length").text("Duration:" + audioElement.duration + " seconds");
                $("#source").text("Source:" + audioElement.src);
                $("#status").text("Status: Ready to play").css("color","green");
            });

            audioElement.addEventListener("timeupdate",function(){
                $("#currentTime").text("Current second:" + audioElement.currentTime);
            });

            $('#play').click(function() {
                audioElement.play();
                $("#status").text("Status: Playing");
            });

            $('#pause').click(function() {
                audioElement.pause();
                $("#status").text("Status: Paused");
            });

            $('#restart').click(function() {
                audioElement.currentTime = 0;
            });
            $('.audio').on('click', function () {

            })
        })

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

        .input{
            height: 100%;
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
    </style>
@endpush
