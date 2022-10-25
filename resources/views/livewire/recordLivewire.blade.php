{{--{{dd($record)}}--}}
<div>


    <div class="gridRecorder">
{{--        NOM DE L'ENREGISTREMENT --}}
        <div class="firstRow name">
            <input
                type="text"
                value="{{$recordModel->name ?? 'Nom de l\'enregistrement' }}"
                name="recordCreate{{$recordModel->id}}"
                class="input is-primary is-small text-center"
                style=""
            >
        </div>
{{--        PROCESS--}}
        <div class="firstRow process">
            <button
                wire:click="stopAudio()"
                class=""
            >
                Process : {{$recordModel->processId}}
            </button>
        </div>
{{--        CATEGORY--}}
        <div class="firstRow category">
            <label> Category
                <input wire:model="recordModel.category" type="text" value="{{$recordModel->category}}">
            </label>
        </div>
{{--        EXECUTION--}}
        <div class="firstRow execution">
            <label>
                Execution
                <input type="text" value="{{json_encode($recordModel->options)}}">
            </label>
        </div>
{{--        PATH--}}
        <div class="firstRow path">
            <label>
                Path
                <input type="text" value="{{$recordModel->path }}">
            </label>
        </div>
{{--        PROCESS--}}
        <div class="firstRow type">
            <label>
                Process
                <input type="text" value="{{$recordModel->processName }}">
            </label>
        </div>
{{--        DEVICE--}}
        <div class="firstRow input1">
            <label>
                Device
                <input type="text" value="{{$recordModel->deviceName }}">
            </label>
        </div>

{{--        RECORD--}}
        <div class="secondRow record">Record</div>
{{--        INFOS--}}
        <div class="secondRow information">Infos</div>
{{--        PLAYER--}}
        <div class="secondRow player">Player</div>
{{--        GRAPHE--}}
        <div class="secondRow graphPlayer">Graphique player</div>
{{--        OUTPUT--}}
        <div class="thirdRow output">Output</div>
    </div>

    <div class="pure-table record table-container" data-id="{{$recordModel->id}}"  >
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
                    <label>
                        <input type="text"
                               value="{{$recordModel->name }}"
                               name="recordCreate{{$recordModel->id}}"
                               class="input is-primary is-small text-center"
                            {{--                           style="width: 35%; margin: 5px;"--}}
                        >
                    </label>
                </td>
                <td colspan="3"><button wire:click="stopAudio()">Process : {{$recordModel->processId}}</button></td>
                <td colspan="2" title="catégorie">
                    <label>
                        <input wire:model="recordModel.category" type="text" value="{{$recordModel->category}}">
                    </label>
                </td>
                <td colspan="2">
                    {{--                {{json_encode($recordModel->options??'', JSON_PRETTY_PRINT)}}--}}
                    {!! \App\Sources\Utils\BladeHelpers::makeDropdownList($recordModel->options!== null ? $recordModel->options['execution']??[] : [], 'Executions') !!}
                </td>
                <td colspan="3" style="overflow: hidden">
                    {{$recordModel->path }}
                </td>
                <td colspan="1" style="overflow: auto">{{$recordModel->processName}}</td>
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
                <td id="ZoneAudioPlayer" colspan="4" controls >
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

</div>
@push('js')
    <script>
        $(document).ready(function() {
            var audioElement = document.createElement('audio');
            $('.audio'.on('click', function(){
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
            }))


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

        {{--function hasUserMedia() {--}}
        {{--    //check if the browser supports the WebRTC--}}
        {{--    return !!(navigator.getUserMedia || navigator.webkitGetUserMedia ||--}}
        {{--        navigator.mozGetUserMedia);--}}
        {{--}--}}

        {{--if (hasUserMedia()) {--}}
        {{--    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia--}}
        {{--        || navigator.mozGetUserMedia;--}}

        {{--    //enabling video and audio channels--}}
        {{--    navigator.getUserMedia({ video: true, audio: true }, function (stream) {--}}
        {{--            var audio = document.querySelector('audio');--}}

        {{--            //inserting our stream to the audio tag--}}
        {{--            audio.src = window.URL.createObjectURL(stream);--}}
        {{--    }, function (err) {});--}}
        {{--} else {--}}
        {{--    alert("WebRTC is not supported");--}}
        {{--}--}}

        {{--$('audio').on('click', function(){--}}
        {{--    $.ajax({--}}
        {{--        url: '{{url('/action/play/0')}}',--}}
        {{--        method : 'POST',--}}
        {{--        data: new FormData(this),--}}
        {{--        processData: false,--}}
        {{--        contentType: false,--}}
        {{--        success: function (e){--}}
        {{--            console.log('success',e);--}}
        {{--            window.ajaxCallFormData = e;--}}
        {{--        },--}}
        {{--        error: function (e){--}}
        {{--            console.log('error',e);--}}
        {{--            let message = e.hasOwnProperty('responseJSON') ? e.responseJSON.message : e.responseText;--}}
        {{--            message = message === '' ? e.statusText : message;--}}
        {{--        },--}}
        {{--        complete: function(){--}}
        {{--            // console.log('data', window.ajaxCallFormData)--}}
        {{--            if(options.reload){--}}
        {{--                location.reload();--}}
        {{--            }--}}
        {{--        }--}}
        {{--    })--}}
        {{--})--}}

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
