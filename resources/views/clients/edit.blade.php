@extends('layouts.app')
@section('title', 'Изменить клиента')
@section('content')
    <form action="{{route('clients.update', $client->id)}}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" value="{{$client->name}}" id="name" name="name" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" value="{{$client->email}}" name="email" class="form-control">
        </div>

        @if($client->socials)
            @foreach($client->socials as $key => $social)
                <div class="form-group">
                    <label for="{{$key}}">{{$key != 'phone' ? $key : 'Телефон'}}</label>
                    <input type="text" id="{{$key}}" value="{{$social}}">
                </div>
            @endforeach
        @endif

        <div class="form-group">
            <label for="note">Заметка</label>
            <input type="text" id="note" value="{{$client->note}}" name="note" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            Сохранить
        </button>
    </form>
@endsection
