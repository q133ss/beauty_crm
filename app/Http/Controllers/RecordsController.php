<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordsController\StatusRequest;
use App\Http\Requests\RecordsController\StoreRequest;
use App\Http\Requests\RecordsController\UpdateRequest;
use App\Models\Record;
use App\Services\Records\StatusService;
use App\Services\Records\StoreService;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recordsIds = Auth()->user()->recordsIds();
        $filter = Record::whereIn('id', $recordsIds)->withFilter(1)->exists() ? 1 : 2;
        $records = Record::whereIn('id', $recordsIds)->withFilter($filter)->get();
        return view('records.index', compact('records','filter'));
    }

    public function filter(Request $request)
    {
        $records = Record::withFilter($request->field)->get();
        return view('ajax.records.index', compact('records'));
    }

    public function sort($filter, $sort, $orientation)
    {
        $records = Record::withFilter($filter, $sort, $orientation)->get();
        return view('ajax.records.index', compact('records'))->render();
    }

    public function status(StatusRequest $request)
    {
        return StatusService::statusChange($request->validated());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth()->user();
        $services = $user->services();
        $clients = $user->clients();
        $salons = $user->salon;
        return view('records.create', compact('services', 'clients', 'salons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        StoreService::store($request->validated());
        return to_route('records.index')->withSuccess('Заявка успешно создана');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = Record::findOrFail($id);
        abort_if(!$record->checkUser(), 403);
        return view('records.show', compact('record'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Record::findOrFail($id);
        $services = Auth()->user()->services();
        return view('records.edit', compact('record', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        //TODO При сохранении нужно добавить евент для форматирования даты!!!
        //TODO При изменении услуги отправляем клиенту уведомление
        $record = Record::findOrFail($id);
        if($record->user_id != Auth()->id()){
            abort(403, 'У вас нет прав');
        }
        $record->update($request->validated());
        return to_route('records.index')->withSuccess('Запись успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
