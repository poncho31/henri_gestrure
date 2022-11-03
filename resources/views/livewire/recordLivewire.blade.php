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
                    class="button input is-small is-info is-small text-center"
                >
            </label>
        </div>
{{--        PROCESS--}}
        <div class="firstRow process" id="ZoneProcess">
            <button
                wire:click="stopAudio()"
                class="button input is-small is-info is-small text-center"
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
                    class="button input is-small is-info is-small text-center"
                >
            </label>
        </div>
{{--        EXECUTION--}}
        <div class="firstRow execution" id="ZoneExecution">
            <label>
                <input
                    type="text"
                    value="{{$recordModel->options !== null ?json_encode($recordModel->options) : 'ececutions'}}"
                    class="button input is-small is-info is-small text-center"
                >
            </label>
        </div>
{{--        PATH--}}
        <div class="firstRow path" id="ZonePath">
            <label>
                <input
                    type="text"
                    value="{{$recordModel->path ?? 'path' }}"
                    class="button input is-small is-info is-small text-center"
                >
            </label>
        </div>
{{--        PROCESS--}}
        <div class="firstRow type" id="ZoneProcess">
            <label>
                <input
                    type="text"
                    value="{{$recordModel->processName ?? 'process' }}"
                    class="button input is-small is-info is-small text-center"
                >
            </label>
        </div>
{{--        DEVICE--}}
        <div class="firstRow input1" id="ZoneDevice">
            <label>
                <input
                    type="text"
                    value="{{$recordModel->deviceName ?? 'device' }}"
                    class="button input is-small is-info is-small text-center"
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
                         class="recorder runRecord button is-success is-small"
                         wire:click="recordAudio()"
                >
                    Record
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
             <span id="recordInfo{{$recordModel->id}}" class="icon has-text-info" title="information">
                 <i class="fa fa-info-circle"></i>
             </span>
            <span id="recordError{{$recordModel->id}}" class="icon has-text-warning" title="Warning">
                <i class="fa fa-exclamation-triangle"></i>
            </span>
        </div>
{{--        PLAYER--}}
        <div class="secondRow player" id="ZoneAudioPlayer">
                 <span>
                     <div id="audio-player-container playRecord" class="hero is-info">
                         <div class="audio audio{{$recordModel->id ?? 0}}">

{{--                             METADATA--}}
                             <div id="length{{$recordModel->id ?? 0}}" style="display: none"></div>
                             <div id="source{{$recordModel->id ?? 0}}" style="display: none">Source:</div>

{{--                             ACTIONS BUTTON--}}
                             <button id="reload{{$recordModel->id ?? 0}}"  class="button is-dark is-small">   Reload</button>
                             <button id="play{{$recordModel->id ?? 0}}"    class="button is-success is-small">Play</button>
                             <button id="pause{{$recordModel->id ?? 0}}"   class="button is-danger is-small"> Pause</button>
                             <button id="restart{{$recordModel->id ?? 0}}" class="button is-primary is-small">Restart</button>

{{--                             STATUS--}}
                             <label id="status{{$recordModel->id ?? 0}}" style="color:red;">
                                 Loading
                             </label>

{{--                             TIME--}}
                             <label id="currentTime{{$recordModel->id ?? 0}}" style="width: 100%">
                                 0 s.
                             </label>
                         </div>
                     </div>
                 </span>
        </div>
{{--        GRAPHE--}}
        <div class="secondRow graphPlayer button input is-success">
            <label for="audioGraph{{$recordModel->id}}">
                ZONE CHART AUDIO PLAYER
            </label>
        </div>
{{--        OUTPUT--}}
        <div class="thirdRow output" id="zo">
            <label for="output{{$recordModel->id??0}}"></label>
                <code style="overflow: scroll"
                >
{{--                    <label for="output{{$recordModel->id ?? 0}}">--}}
                        <textarea
                            id="output{{$recordModel->id ?? 0}}"
                            style="width: 100%; height: 100%"
                        >
                            ZONE OUTPUT N° {{$recordModel->id}}
                            {{$output}}
                        </textarea>
{{--                    </label>--}}
            </code>


{{--            <code--}}
{{--                id="output{{$recordModel->id ?? 0}}"--}}
{{--            >--}}
{{--                    <textarea style="width: 100%; height: 100%; max-width: 100%; position:relative;">--}}
{{--                    ZONE OUTPUT N° {{$recordModel->id}}--}}
{{--                        {{$output}}--}}
{{--                    </textarea>--}}
{{--            </code>--}}
        </div>
    </div>
    <hr>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            let id = '{{$recordModel->id ?? 0}}'

            let audioElement = document.createElement('audio');
            audioElement.id = 'audioId'+id

            let lenght      = $("#length"+id)
            let source      = $("#source"+id)
            let status      = $("#status"+id)
            let currentTime = $("#currentTime"+id)
            let restart     = $("#restart"+id)
            let reload      = $("#reload"+id)
            let pause       = $("#pause"+id)
            let play        = $("#play"+id)
            let output      = $('#output' + id)
            let isPlaying   = audioElement.currentTime

            // EVENT LISTENER
            audioElement.addEventListener("canplay",function(){
                lenght.text("Duration:" + audioElement.duration + " seconds");
                source.text("Source:" + audioElement.src);
                status.text("Ready to play").css("color","green");
            });

            audioElement.addEventListener("timeupdate",function(){
                lenght.text("Duration:" + audioElement.duration + " seconds");
                isPlaying   = audioElement.currentTime
                currentTime.text("Time : " + audioElement.currentTime + " / " + audioElement.duration) ;
            });

            //PLAY
            play.click(function() {
                if(audioElement.className==='isRecord{{$recordModel->id}}'){
                    audioElement.play();
                    output.append("Play cache stream")
                }
                else{
                    ajaxAudio(audioElement, '{{url('stream/audio/')}}' +'/'+id, {{$recordModel->id ?? 0}})
                    audioElement.play();
                    output.append("Play new load stream")
                }

                output.append("Playing")
                status.text("Playing");
            });

            //RELOAD
            reload.on('click',function(){
                ajaxAudio(audioElement, '{{url('stream/audio/')}}' +'/'+id, {{$recordModel->id ?? 0}})
                output.append("Reload")
            })
            //PAUSE
            pause.click(function() {
                audioElement.pause();
                status.text("Paused");
                output.append("Pause")
            });
            //RESTART
            restart.click(function() {
                audioElement.currentTime = 0;
                output.append("Restart")
            });
        })


        async function ajaxAudio(audioElement, url, id){
            return await $.ajax({
                url: url,
                type: "POST",
                success: function (data) {
                    // console.log(data)
                    $('#output' + id).append(data)
                    audioElement.id = id
                    audioElement.setAttribute('src', 'http://localhost:8080/stream/' + id);
                    // audioElement.setBuffer()
                    audioElement.addEventListener('ended', function () {
                        this.play()
                    }, false)
                    audioElement.pause()
                    audioElement.load()
                    audioElement.play()
                    audioElement.className='isRecord'+id
                },
                error: function (error) {
                    console.log(error)
                    $('#output' + id).append(error);
                }
            });
        }
    </script>
@endpush
