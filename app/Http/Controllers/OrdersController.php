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
        $orders = Order::getForSalon(Auth()->id())
            //->withFilter('confirmed')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function filter($field, $sort='id', $orientation='DESC')
    {
        $orders = Order::getForSalon(Auth()->id())->withFilter($field, $sort, $orientation)->get();
        return view('ajax.orders.index', compact('orders'))->render();
    }

    public function updateStatus($id, UpdateStatusRequest $request)
    {
        #TODO проверка заказа!!!!!!!
        Order::find($id)->update($request->validated());
        return to_route('orders.index')->withSuccess('Статус заказа успешно изменен');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        #TODO Сделать проверку на заказ!! Принадлежит ли он юзеру
        return view('orders.show', compact('order'));
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
        #TODO сделать проверку на ордер
        return view('orders.edit', compact('order', 'services'));
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
        Order::findOrFail($id)->update($request->validated());
        return to_route('orders.index')->withSuccess('Запись успешно обновлена');
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
