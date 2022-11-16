@extends('layouts.app')
@section('title', 'Просмотр записи')
@section('content')
    <ul class="list-arrow">
        <li>Клиент: <a href="#">{{$record->client->name}}</a></li>
        <li>Услуга: <a href="#">{{$record->service->name}}</a></li>
        <li>Дата и время: <date class="font-weight-bold">{{$record->date}} : {{$record->time->time}}</date><i class="fa fa-calendar ml-1 text-primary"></i></li>
    </ul>
    <button class="btn btn-info">Связаться с клиентом</button>
    <button class="btn btn-primary">Подтвердить запись</button>
    <button class="btn btn-secondary">Отменить запись</button>
@endsection
