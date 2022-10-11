{{--        AUDIO PLAYER--}}
<div id="audio-player-container playRecord">
    <audio controls>
        <source src="{{ $record->fullpath ??'template.mp3'}}"  type="audio/mp3">
    </audio>
</div>
