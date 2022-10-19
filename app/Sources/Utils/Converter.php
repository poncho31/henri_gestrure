<?php

namespace App\Sources\Utils;

class Converter
{
    public static function loopToArray(array $data, $key = null, bool $isDropdownList = false): array
    {
        $result = [];
        $html = "<ul class='child'>";
        foreach ($data as $k => $el){
            if(is_array($el) || is_object($el)){
                $el = (array) $el;
                $html .= "<ul>";
                $result [$k] = self::loopToArray($el, $k, $isDropdownList);
                $html .= "</ul>";
            }
            else{
                $result[$k]="$el";
                $html .= "<li class='parentMenu'>$el</li>";
            }
        }
        $html .="</ul>";
        return $result;
    }
}
