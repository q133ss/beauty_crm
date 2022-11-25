<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdersController\UpdateRequest;
use App\Http\Requests\OrdersController\UpdateStatusRequest;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::getForSalon(Auth()->id())->get();
        return view('orders.index', compact('orders'));
    }

    public function filter($field, $sort='id', $orientation='DESC')
    {
        $orders = Order::getForSalon(Auth()->id())->withFilter($field, $sort, $orientation)->get();
        return view('ajax.orders.index', compact('orders'))->render();
    }

    public function updateStatus($id, UpdateStatusRequest $request)
    {
        $order = Order::find($id);
        if($order->checkAccess(Auth()->id())) {
            $order->update($request->validated());
            return to_route('orders.index')->withSuccess('Статус заказа успешно изменен');
        }
        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::getForSalon(Auth()->user()->salons->pluck('id')->all())->get();
        $clients = Auth()->user()->getClients();
        return view('orders.create', compact('services', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        if($order->checkAccess(Auth()->id())) {
            return view('orders.show', compact('order'));
        }
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrfail($id);
        $services = Service::getForSalon(Auth()->user()->salons->pluck('id')->all())->get();
        if($order->checkAccess(Auth()->id())) {
            return view('orders.edit', compact('order', 'services'));
        }
        abort(403);
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
        $order = Order::findOrFail($id);
        if($order->checkAccess(Auth()->id())) {
            $order->update($request->validated());
            return to_route('orders.index')->withSuccess('Запись успешно обновлена');
        }
        abort(403);
    }
}
