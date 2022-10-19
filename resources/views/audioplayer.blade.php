<span id="audioPlayer{{$recordModel->id}}" >
     <div id="audio-player-container playRecord">
         <audio controls wire:click="test">
             <source src="http://localhost:8080/stream/{{$recordModel->name}}" type="audio/mp3">
             <source src="http://localhost:8080/stream/{{$recordModel->name}}" type="audio/ogg">
{{--                 {{ asset('files/audio').'/' .( $recordModel->name ??'template.mp3')}}--}}
         </audio>
     </div>
 </span>
@push('js')
    <script>
        $.ajax({
            url: $('/').attr('action'),
            method : $($this).attr('method'),
            data: new FormData($this),
            processData: false,
            contentType: false,
            success: function (e){
                console.log('success',e);
                window.ajaxCallFormData = e;
            },
            error: function (e){
                console.log('error',e);
                let message = e.hasOwnProperty('responseJSON') ? e.responseJSON.message : e.responseText;
                message = message === '' ? e.statusText : message;
            },
            complete: function(){
                // console.log('data', window.ajaxCallFormData)
                if(options.reload){
                    location.reload();
                }
            }
        })
    </script>
@endpush
