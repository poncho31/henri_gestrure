<?php

namespace App\GreatModel;

class GreatModel
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
