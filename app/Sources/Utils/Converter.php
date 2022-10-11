<?php

namespace App\Sources\Utils;

class Converter
{
    public static function loopToArray(array $data, $key = null): array
    {
        $result = [];
        foreach ($data as $k => $el){
            if(is_array($el) || is_object($el)){
                $el = (array) $el;
                $result [$k] = self::loopToArray($el, $k);
            }
            else{
                $result[$k]="$el";
            }
        }
        return $result;
    }
}
