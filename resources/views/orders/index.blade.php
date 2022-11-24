@extends('layouts.app')
@section('title', 'Заказы')
@section('meta')
    <link rel="stylesheet" href="/css/custom.css">
@endsection
@section('content')
    <div class="alert alert-info">На этой странице отображены все заявки от клиентов на ваши услуги.
        Вы можете воспользоваться поиском, а так же отфильтровать и отсортировать их</div>
    <div class="row">
        <div class="col">
            <div class="btn btn-outline-primary btn-fw">Добавить</div>
        </div>
        <div class="col">
            <select name="" onchange="filter($(this).val())" id="" class="form-select form-control">
                <option value="all">Все</option>
                <option value="not_processed">Не обработанные</option>
                <option value="confirmed">Подтвержденные</option>
                <option value="rejected">Отклоненые</option>
                <option value="waiting_for_payment">Ожидают оплату</option>
                <option value="сompleted">Завершенные</option>
                <option value="not_paid">Не оплаченные</option>
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
            <th class="sort-col" data-field="client">
                Услуга
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
        <tbody id="orders">
        @foreach($orders as $order)
        <tr>
            <td>
                {{$order->id}}
            </td>
            <td>
                <a href="{{route('clients.show', $order->client->id)}}">{{$order->client->name}}</a>
            </td>
            <td>
                <a href="#">{{$order->service->name}}</a>
            </td>
            <td>
                {{$order->getDate()}}
            </td>
            <td>
                {{$order->time}}
            </td>
            <td>
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
            </td>
            <td>
                <a class="btn btn-outline-info btn-fw" href="{{route('orders.show', $order->id)}}">Смотреть</a>
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
            $('.sort-col').find('i').css('color', '#666666');

            let params = (new URL(document.location)).searchParams;

            field = params.get("filter"); //берем из урл
            let sort = $(this).data('field');
            let orientation = 'DESC';

            if(!field){
                field = 'all';
            }

            if(lastOrder === 'ASC'){
                orientation = 'ASC';
                lastOrder = 'DESC';
                $(this).find('i.fa-arrow-up').css('color', '#ec37fc');
            }else{
                orientation = 'DESC';
                lastOrder = 'ASC';
                $(this).find('i.fa-arrow-down').css('color', '#ec37fc');
            }

            $.ajax({
                url: '/orders/filter/'+field+'/'+sort+'/'+orientation,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#orders').html(data)
                },
                error: function (request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            });
        });

        //Фильтры
        function filter(field){
            history.pushState({}, '', '?filter='+field);

            $.ajax({
                url: '/orders/filter/'+field,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#orders').html(data)
                },
                error: function (request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            });
        }
    </script>
@endsection
