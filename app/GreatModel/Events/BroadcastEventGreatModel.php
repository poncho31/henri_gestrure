<?php

namespace App\GreatModel\Events;

use App\GreatModel\GreatModel;
use Mockery\Matcher\Any;

class BroadcastEventGreatModel extends GreatModel
{

    public ?string               $type       = '';
    public ?string               $chanelName = '';
    public ?bool                 $isPrivate  = true;
    public ?bool                 $isEnd      = false;
    public string|array|null     $data       = null;

}
