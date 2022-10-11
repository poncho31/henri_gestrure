<?php

namespace App\Console\Commands;

use App\Models\Record;
use App\Sources\AudioPlayer\AudioPlayer;
use App\Sources\AudioPlayer\Players\Player;
use Illuminate\Console\Command;

class test_cmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new Player())->streamVlc((new Record()));
    }
}
