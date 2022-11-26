<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientController\StoreRequest;
use App\Http\Requests\ClientController\UpdateRequest;
use App\Models\User;
use App\Services\Clients\StoreService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth()->user();
        $clients = $user->getClients();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $salons = Auth()->user()->salons;
        return view('clients.create', compact('salons'));
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
        return to_route('clients.index')->withSuccess('Клиент успешно добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = User::find($id);

        if(Auth()->user()->checkClient($id)) {
            return view('clients.show', compact('client'));
        }else{
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = User::findOrFail($id);
        if(Auth()->user()->checkClient($id)) {
            return view('clients.edit', compact('client'));
        }else{
            abort(403);
        }
    }

    public function getContact($client_id)
    {
        $contacts = User::find($client_id);
        return view('ajax.clients.contacts', compact('contacts'));
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
        if(Auth()->user()->checkClient($id)) {
            User::find($id)->update($request->validated());
            return to_route('clients.index')->withSuccess('Клиент успешно обновлен');
        }else{
            abort(403);
        }
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
