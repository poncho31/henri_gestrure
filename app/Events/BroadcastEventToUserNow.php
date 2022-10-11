<?php

namespace App\Events;

use App\GreatModel\Events\BroadcastEventGreatModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BroadcastEventToUserNow implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public BroadcastEventGreatModel $model;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new BroadcastEventGreatModel();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|PrivateChannel
     */
    public function broadcastOn(): Channel|PrivateChannel
    {
        if($this->model->isPrivate){
            return new PrivateChannel($this->model->chanelName);
        }
        else{
            return new Channel($this->model->chanelName);
        }
    }

    /**
     * Data SEND to the event broadcast
     * @return array
     */
    public function broadcastWith(): array
    {
        return $this->model->toArray();
    }


//    public function broadcastAs(): array
//    {
//        return $this->model->toArray();
//    }

    public function broadcastEventSend(?string $type = null, ?string $chanelName = null, $data = [],bool $isPrivate = true, bool $isEnd = false): ?array
    {
        $this->model->type       = $type;
        $this->model->chanelName = $chanelName;
        $this->model->isPrivate  = $isPrivate;
        $this->model->data       = $data;
        $this->model->isEnd      = $isEnd;
        return $this->send();
    }

    public static function sendToUser(?string $type = null, ?string $chanelName = null, $data = [],bool $isPrivate = true, bool $isEnd = false){
        (new self)->broadcastEventSend(...get_defined_vars());
    }

    public function modelBroadcastEventSend(BroadcastEventGreatModel $model): ?array
    {
        $this->model = $model;
        return $this->send();
    }

    public function send(): ?array
    {
        return event($this);
    }
}
