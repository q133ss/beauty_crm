@extends('layouts.app')
@section('title', 'Просмотр записи')
@section('content')
    <ul class="list-arrow">
        <li>Клиент: <a href="#">{{$record->client->name}}</a></li>
        <li>Услуга: <a href="#">{{$record->service->name}}</a></li>
        <li>Время работы: {{$record->service->workTime()}}</li>
        <li>Дата и время проведения процедуры: <date class="font-weight-bold">{{$record->date()}} в {{$record->timeFormatted()}}</date><i class="fa fa-calendar ml-1 text-primary"></i></li>
    </ul>

    @if($record->status->name == 'confirmed')
        <form action="{{route('records.status')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{$record->id}}">
            <input type="hidden" name="status_id" value="3">
            <p class="text-success">Вы подтвердите эту запись <button type="submit" class="btn btn-link btn-fw">Отменить запись</button> </p>
        </form>
    @elseif($record->status->name == 'rejected')
        <form action="{{route('records.status')}}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="id" value="{{$record->id}}">
            <input type="hidden" name="status_id" value="2">
            <p class="text-danger">Вы отменили эту запись <button type="submit" class="btn btn-link btn-fw">Подтвердить запись</button></p>
        </form>
    @else
        <form action="{{route('records.status')}}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="id" value="{{$record->id}}">
            <input type="hidden" name="status_id" value="2">
            <button type="submit" class="btn btn-primary">Подтвердить запись</button>
        </form>
        <form action="{{route('records.status')}}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="id" value="{{$record->id}}">
            <input type="hidden" name="status_id" value="3">
            <button type="submit" class="btn btn-secondary">Отменить запись</button>
        </form>
    @endif

    <button class="btn btn-info">Связаться с клиентом</button>

@endsection
