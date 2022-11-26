@extends('layouts.app')
@section('title', 'Клиенты')
@section('meta')
    <link rel="stylesheet" href="/css/custom.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
    <div class="alert alert-info">На этой странице отображены все заявки от клиентов на ваши услуги.
        Вы можете воспользоваться поиском, а так же отфильтровать и отсортировать их</div>
    <div class="row">
        <div class="col">
            <a href="{{route('orders.create')}}" class="btn btn-outline-primary btn-fw">Добавить</a>
        </div>
        <div class="col">
            <select name="" onchange="filter($(this).val())" id="" class="form-select form-control" style="padding: .375rem 2.25rem .375rem .75rem">
                <option value="all">Салон</option>
            </select>
        </div>
        <div class="col">
            <input type="text" placeholder="Поиск" class="form-select">
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
            <th>
                Фото
            </th>
            <th class="sort-col" data-field="name">
                Имя
                <div class="table-sort-arrows">
                    <i class="fa fa-arrow-up"></i>
                    <i class="fa fa-arrow-down"></i>
                </div>
            </th>
            <th class="sort-col" data-field="lastOrder" data-toggle="tooltip" data-placement="top" title="Дата, в которую клиент создал последний заказ">
                Последний заказ
                <div class="table-sort-arrows">
                    <i class="fa fa-arrow-up"></i>
                    <i class="fa fa-arrow-down"></i>
                </div>
            </th>

            <th>
                Контакты
            </th>

            <th>
                Действия
            </th>
        </tr>
        </thead>
        <tbody id="orders">
        @foreach($clients as $client)
        <tr>
            <td>
                {{$client->id}}
            </td>
            <td>
                <img src="{{$client->avatar()}}" width="100px" alt="">
            </td>
            <td>
                {{$client->name}}
            </td>
            <td>
                {{$client->lastOrderDate() ? $client->lastOrderDate() : 'Нет заказов'}}
            </td>
            <td>
                <button class="btn btn-outline-info" onclick="getContact('{{$client->id}}')">Контакты</button>
            </td>
            <td>
                <button class="btn btn-outline-success">Смотерть</button>
                <button class="btn btn-outline-warning">Изменить</button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('scripts')

    <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Контакты</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contactBody">
                </div>
            </div>
        </div>
    </div>

    <script>
        //Tooltip
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
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

        function getContact($client_id){
            $.ajax({
                url: 'clients/'+$client_id+'/get-contact',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#contactBody').html(data)
                    $('#contactModal').modal('show')
                },
                error: function (request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            });
        }
    </script>
@endsection
