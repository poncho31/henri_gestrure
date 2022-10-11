@extends('layouts.app.app')

@section('content')
    {{-- RECORD --}}
    <h3 class="title">Enregistrer</h3>

    <div style="margin: 0 1% 0 1%">
        @livewire('record-livewire')
        <hr>
    </div>


    <h3 class="title">Derniers enregistrements</h3>

    <div style="margin: 0 1% 0 1%">
        <div class="block">
            <ul>
                @foreach($records->all as $record)
                    <li>
                        @livewire('record-livewire', ['record'=>$record])
                    </li>
                @endforeach
            </ul>
            {{ $records->all->links() }}
        </div>
    </div>
    </div>
{{--    --}}{{-- AUDIO PLAYER --}}
{{--    @include('audioplayer')--}}
@endsection

@section('js')
    <script>
        // window.recordFunction.run()        // Implementer les alertes reçues ici (ex: console de l'enregistrement / fin de l'enregistrement)
    </script>
@endsection

