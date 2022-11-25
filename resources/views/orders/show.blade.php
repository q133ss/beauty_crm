@extends('layouts.app')
@section('title', 'Просмотр заказа')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <div class="row">
        <div class="col-8">
            <div class="bg-white rounded p-4">
                <h5>Заказ</h5>
                <ul class="list-arrow">
                    <li>Клиент: <a href="#">{{$order->client->name}}</a></li>
                    @if(Auth()->user()->isSalon)
                        <li>Салон: <a href="#">{{$order->salon->name}}</a></li>
                    @endif
                    <li>Название услуги: <a href="#">{{$order->service->name}}</a></li>
                    <li>Цена: {{$order->price}}</li>
                    <li>Дата и время: {{$order->getDate()}} в {{$order->getTime()}}</a></li>
                    <li>Статус:
                        @if($order->status('code') == 'confirmed')
                            <span class="text-primary">{{$order->status('name')}}</span>
                        @elseif($order->status('code') == 'rejected')
                            <span class="text-danger">{{$order->status('name')}}</span>
                        @elseif($order->status('code') == 'not_processed')
                            <span class="text-info">{{$order->status('name')}}</span>
                        @elseif($order->status('code') == 'waiting_for_payment')
                            <span class="text-warning">{{$order->status('name')}}</span>
                        @elseif($order->status('code') == 'сompleted')
                            <span class="text-success">{{$order->status('name')}}</span>
                        @elseif($order->status('code') == 'not_paid')
                            <span class="text-danger">{{$order->status('name')}}</span>
                        @else
                            <span>{{$order->status('name')}}</span>
                        @endif
                    </li>

                </ul>
                @if($order->order_status_id == 1)
                <form action="{{route('orders.status.change', $order->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="order_status_id" value="2">
                    <button class="btn btn-inverse-success">Принять</button>
                </form>
                <form action="{{route('orders.status.change', $order->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="order_status_id" value="3">
                    <button class="btn btn-inverse-danger">Отклонить</button>
                </form>
                @elseif($order->order_status_id == 2)
                    <form action="{{route('orders.status.change', $order->id)}}" class="d-flex align-items-center" method="POST">
                        @csrf
                        <input type="hidden" name="order_status_id" value="3">
                        <p class="m-0">Вы <span class="text-success">приняли заказ</span>.</p>
                        <button class="btn btn-link btn-fw">Отменить</button>
                    </form>
                @elseif($order->order_status_id == 3)
                    <form action="{{route('orders.status.change', $order->id)}}" method="POST" class="d-flex align-items-center">
                        @csrf
                        <input type="hidden" name="order_status_id" value="2">
                        <p class="m-0">Вы <span class="text-danger">отменили заказ</span>.</p>
                        <button class="btn btn-link btn-fw">Принять</button>
                    </form>
                @endif
            </div>
        </div>
        <div class="col-4">
            <div class="bg-white rounded p-4 h-100">
                <h5>Контакты</h5>
                <ul class="list-arrow">
                    <li>Телефон: {{$order->client->phone}}</li>
                    @if($order->client->telegram)
                        <li>Telegram: {{$order->client->telegram}}</li>
                    @endif
                    @if($order->client->socials())
                        @foreach($order->client->socials() as $name => $social)
                            <li>{{$name}}: {{$social}}</li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <div class="container mt-4 bg-white rounded p-4">
        <h5>Чат</h5>
        <div class="bg-dark rounded p-4">
            <div class="d-flex justify-content-start mb-4 align-items-center">
                <img src="{{Auth()->user()->avatar()}}" alt="" style="width: 50px">
                <div class="bg-info text-white p-2 rounded">
                    Здравствуйте!
                </div>
            </div>
            <div class="d-flex justify-content-end mb-4 align-items-center">
                <div class="bg-primary text-white p-2 rounded">
                    Привет))
                </div>
                <img src="{{Auth()->user()->avatar()}}" alt="" style="width: 50px">
            </div>
        </div>
        <textarea name="" id="" cols="10" class="w-100 mt-2 rounded form-control" rows="5" placeholder="Сообщение.."></textarea>
        <div class="d-flex justify-content-end mt-2">
            <button class="btn btn-info">Отправить</button>
        </div>
    </div>
@endsection
