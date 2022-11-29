@extends('layouts.app')
@section('title', $title)
@section('content')
    <div class="d-flex justify-content-between mb-4">
        <h3>{{$title}}</h3>
        <a href="{{route('finances.index')}}" class="btn btn-outline-info">Статистика</a>
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>
                Дата
            </th>
            <th>
                Тип
            </th>
            <th>
                Сумма
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $finance)
        <tr>
            <td>
                {{$finance->getDate()}}
            </td>
            <td class="finance-type">
                {{$finance->type}}
            </td>
            <td>
                {{$finance->sum}} ₽
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('scripts')
    <style>
        .finance-type:first-letter{
            text-transform: uppercase;
        }
    </style>
@endsection
