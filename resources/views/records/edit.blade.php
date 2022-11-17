@extends('layouts.app')
@section('title', 'Просмотр записи')
@section('content')
    <form action="{{route('records.status')}}" method="POST" class="d-inline">
        @csrf
        <div class="form-group">
            <label>Дата</label>
            <input type="text" class="form-control form-control-sm" placeholder="Username" aria-label="Username">
        </div>

        <div class="form-group">
            <label>Время</label>
            <input type="text" class="form-control form-control-sm" placeholder="Username" aria-label="Username">
        </div>

        <div class="form-group">
            <label>Услуга</label>
            <input type="text" class="form-control form-control-sm" placeholder="Username" aria-label="Username">
        </div>
    </form>
@endsection
