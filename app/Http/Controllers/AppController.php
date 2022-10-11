<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppController extends Controller
{


    public function __construct(){
    }

    public function index(Request $request): Factory|View|Application
    {
        $records      = new \stdClass();
        $records->all = (new Record())->orderBy('updated_at', 'desc')
                                      ->orderBy('id', 'desc')
                                      ->paginate(5);
        return view("app", compact('records'));
    }

    public function streamaudio(): View|Factory|Application
    {
        return \view('streamaudio');
    }
}
