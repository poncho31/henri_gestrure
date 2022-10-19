<?php

namespace App\Sources\Utils;

class BladeHelpers
{
    public static function makeDropdownList(array $data, $key = null): string
    {
        $html = "<div class='dropDownList$key".(rand(0,1000))." dropDownList'>";
        $html .="<ul>".self::htmlMakeDropdownList($data, $key)."</ul>";
        $html .= "</div>";
        $css = self::cssMakeDropDownList();
        return $css . $html;
    }
    private static function htmlMakeDropdownList(array $data, $key = null, string $html = ""): string{
        $result = [];
        $html .= "<li class='parentMenu'>";
        $html .= "<a>$key<span class='expand'>»</span></a>";
        $html .= "<ul class='child'>";
        foreach ($data as $k => $el){
//            dd($data);
            if(is_array($el) || is_object($el)){
                $el = (array) $el;
//                dump($el);
                $html .= self::htmlMakeDropdownList($el, $k);
            }
            else{
//                $result[$k]="$el";
                $html .= "<li class='element'>
                            <table>
                                <tr>
                                    <td>$k : </td>
                                    <td><code>$el</code></td>
                                </tr>
                            </table></li>";
            }

        }
        $html .= "</ul>";
        $html .="</li>";

//        dd($html);
        return  $html;
    }
    private static function cssMakeDropDownList(): string
    {
        return "    <style>
            .edge ul {
                right:0;
            }

        .blockElement{
            position: fixed;
        }
        .dropDownList{
            z-index: 100;
            position: absolute;
        }
        li.element code{
//            background-color: #56d2af;
        }

        li.element{
            color: black;
        }

        .parentMenu {
            display: block;
            position: relative;
            float: right;
            line-height: 30px;
            background-color: #4FA0D8;
            border-right: #CCC 1px solid;
        }

        .parentMenu a {
            margin: 10px;
            color: #FFFFFF;
            text-decoration: none;
        }

        .parentMenu:hover>ul {
            display: block;
            position: absolute;
        }

        .child {
            display: none;
        }

        .child li {
            background-color: #E4EFF7;
            line-height: 30px;
            border-bottom: #CCC 1px solid;
            border-right: #CCC 1px solid;
            width: 100%;
        }

        .child li a {
            color: #000000;
        }

        ul {
            list-style: none;
            margin: 5px;
            padding: 5px;
            min-width: 10em;
        }

        ul ul ul {
            left: 100%;
            top: 0;
            margin-left: 1px;
        }

        li:hover {
            background-color: #95B4CA;
        }

        .parentMenu li:hover {
            background-color: #F0F0F0;
        }

        .expand {
            font-size: 12px;
            float: right;
            margin-right: 5px;
        }
    </style>";
    }
}
