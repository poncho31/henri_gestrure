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
{{--    --}}{{-- AUDIO PLAYER --}}
{{--    @include('audioplayer')--}}
@endsection

@section('js')
    <script>
        // window.recordFunction.run()        // Implementer les alertes reçues ici (ex: console de l'enregistrement / fin de l'enregistrement)
    </script>


@endsection

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


        .parent {
            display: grid;
            grid-template-columns: repeat(24, 1fr);
            grid-template-rows: repeat(10, 1fr);
            grid-column-gap: 1px;
            grid-row-gap: 1px;
        }

        .div1 { grid-area: 3 / 21 / 6 / 22; }
        .div2 { grid-area: 5 / 21 / 6 / 22; }
        .div3 { grid-area: 5 / 21 / 6 / 22; }
        .div4 { grid-area: 5 / 18 / 6 / 21; }
        .div5 { grid-area: 5 / 14 / 6 / 15; }
        .div6 { grid-area: 5 / 14 / 6 / 18; }
        .div7 { grid-area: 5 / 17 / 9 / 18; }
        .div8 { grid-area: 5 / 14 / 9 / 15; }
        .div9 { grid-area: 6 / 16 / 9 / 17; }
        .div10 { grid-area: 1 / 1 / 10 / 23; }
        .div11 { grid-area: 10 / 22 / 11 / 23; }
        .div12 { grid-area: 6 / 17 / 9 / 22; }
        .div13 { grid-area: 2 / 3 / 5 / 7; }
        .div14 { grid-area: 6 / 4 / 10 / 10; }
    </style>
@endpush

