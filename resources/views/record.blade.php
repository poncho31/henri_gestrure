
@php

    $recordId     =  isset($record) && !empty($record) ?  $record->id   : '0';
    $recordName   =  isset($record) && !empty($record) ?  $record->name : '0';
    $recordOption =  !empty($record['options']) ?  $record['options']   :
    [
        'bloc1'=>[
            'max-heigt'=> '50px'
        ],
        'bloc2'=>[
            'max-height'=> '100px'
        ] ,
        'bloc3'=>[
            'max-height'=> '100px'
        ] ,
    ];
@endphp
<div class="record table-container" data-id="{{$recordId}}"  >
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
                           value="{{$recordName }}"
                           name="recordCreate{{$recordId}}"
                           class="input is-primary is-small text-center"
{{--                           style="width: 35%; margin: 5px;"--}}
                    >
            </td>
            <td colspan="15"></td>
        </tr>
        <tr id="recorderSecondLine">
{{--   RECORD --}}
            <td id="ZoneRecord" colspan="2">
                {{--    RUN --}}
                <button  id="runRecord{{$recordId}}"
                         data-id="{{$recordId}}"
                         data-url="{{url('recorder/run/'.$recordId)}}"
                         class="recorder runRecord button is-success h-16"
                >
                    Play Record
                </button>
              {{--    STOP--}}
                <button id="stopRecord{{$recordId}}"
                        data-id="{{$recordId}}"
                        data-url="{{url('recorder/stop/'.$recordId)}}"
                        class="recorder stopRecord button is-danger is-light h-16 display"
                >
                    Stop record {{$recordId}}
                </button>
            </td>
{{--            INFOS / ERRROR--}}
            <td id="ZoneInfo" colspan="1">
                 <span id="recordInfo{{$recordId}}" class="icon has-text-info" title="informaition">
                   <i class="fa fa-info-circle"></i>
                 </span>

                 <span id="recordError{{$recordId}}" class="icon has-text-warning" title="Warning">
                   <i class="fa fa-exclamation-triangle"></i>
                 </span>
            </td>

{{--    AUDIO PLAYER--}}
            <td id="ZoneAudioPlayer" colspan="4">
                <span id="audioPlayer{{$recordId}}" >
                    @include('audioplayer')
                </span>
            </td>
{{-- GRAPHE AUDIO --}}
            <td id="ZoneGraphePlayer" colspan="13" rowspan="2">
                <span id="audioGraph{{$recordId}}"  >
                    ZONE GRAPHE PLAYER
                </span>
            </td>
        </tr>
{{--        OUTPUT--}}
        <tr id="recorderThirdLine">
            <td colspan="7" id="ZoneOutput">
                <div id="output{{$recordId}}">
                    ZONE OUTPUT N° {{$recordId}}
                </div>
            </td>
            <td colspan="13" ></td>
        </tr>
    </table>


</div>
@push('css')
    <style>
        td{
            width: 5vw;
        }
        table{
            width: 99%;
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
