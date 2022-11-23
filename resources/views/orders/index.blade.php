@extends('layouts.app')
@section('title', 'Заказы')
@section('meta')
    <link rel="stylesheet" href="/css/custom.css">
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="btn btn-outline-primary btn-fw">Добавить</div>
        </div>
        <div class="col">
            <select name="" id="" class="form-select form-control">
                <option value="">Фильтр</option>
            </select>
        </div>
    </div>

    <table class="table mt-3">
        <thead>
        <tr class="sort-table-header">
            <th class="sort-col" data-field="id">
                №
                <div class="table-sort-arrows">
                    <i class="fa fa-arrow-up"></i>
                    <i class="fa fa-arrow-down"></i>
                </div>
            </th>
            <th class="sort-col" data-field="client">
                Клиент
                <div class="table-sort-arrows">
                    <i class="fa fa-arrow-up"></i>
                    <i class="fa fa-arrow-down"></i>
                </div>
            </th>
            <th class="sort-col" data-field="date">
                Дата
                <div class="table-sort-arrows">
                    <i class="fa fa-arrow-up"></i>
                    <i class="fa fa-arrow-down"></i>
                </div>
            </th>
            <th class="sort-col" data-field="time">
                Время
                <div class="table-sort-arrows">
                    <i class="fa fa-arrow-up"></i>
                    <i class="fa fa-arrow-down"></i>
                </div>
            </th>
            <th class="sort-col" data-field="status">
                Статус
                <div class="table-sort-arrows">
                    <i class="fa fa-arrow-up"></i>
                    <i class="fa fa-arrow-down"></i>
                </div>
            </th>

            <th>
                Действия
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
        <tr>
            <td>
                {{$order->id}}
            </td>
            <td>
                <a href="{{route('clients.show', $order->client->id)}}">{{$order->client->name}}</a>
            </td>
            <td>
                {{$order->getDate()}}
            </td>
            <td>
                {{$order->time}}
            </td>
            <td>
                {{$order->status('name')}}
            </td>
            <td>
                <a class="btn btn-outline-info btn-fw" href="#">Смотреть</a>
                <a class="btn btn-outline-warning btn-fw" href="#">Изменить</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('scripts')
    <script>
        //Сортировка
        let lastOrder = 'ASC';
        $('.sort-col').click(function (){
            $('.sort-col').css('font-weight', '500')
            $(this).css('font-weight', '700')

            let url = '';
            $('.sort-col').find('i').css('color', '#666666');

            if(lastOrder === 'ASC'){
                url = 'ASC';
                lastOrder = 'DESC';
                $(this).find('i.fa-arrow-up').css('color', '#ec37fc');
            }else{
                url = 'DESC';
                lastOrder = 'ASC';
                $(this).find('i.fa-arrow-down').css('color', '#ec37fc');
            }

            console.log(url)
        });
    </script>
@endsection
