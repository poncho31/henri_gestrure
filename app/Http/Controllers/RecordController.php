<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Http\Requests\StoreRecordRequest;
use App\Http\Requests\UpdateRecordRequest;
use App\Sources\AudioRecording\AudioRecording;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RecordController extends Controller
{

    private int|false       $phpProcess;
    private AudioRecording  $audio;
    private Record          $record;

    public function __construct(){
        $this->phpProcess = getmypid();
        $this->audio      = new AudioRecording($this->phpProcess);
        $this->record     = new Record();
    }

    public function recordAudio(): int|string|null
    {
        return (new AudioRecording(getmypid()))->recordAudio();
    }

    public function killProcess(Request $request){
        $this->audio->killProcess($request->input('process'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRecordRequest  $request
     * @return Response
     */
    public function store(StoreRecordRequest $request): Response
    {
        return response();
    }

    /**
     * Display the specified resource.
     *
     * @param Record $record
     * @return Response
     */
    public function show(Record $record): Response
    {
        return response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Record $record
     * @return Response
     */
    public function edit(Record $record): Response
    {
        return response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRecordRequest $request
     * @param Record $record
     * @return Response
     */
    public function update(UpdateRecordRequest $request, Record $record): Response
    {
        return response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Record $record
     * @return Response
     */
    public function destroy(Record $record): Response
    {
        return response();
    }
}
