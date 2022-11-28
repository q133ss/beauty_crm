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
            <a href="{{route('clients.create')}}" class="btn btn-outline-primary btn-fw">Добавить</a>
        </div>
        <div class="col">
            <select name="" onchange="filter($(this).val())" id="" class="form-select form-control" style="padding: .375rem 2.25rem .375rem .75rem">
                <option value="all">Салон</option>
                @foreach($user->salons as $salon)
                    <option value="{{$salon->id}}">{{$salon->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <input type="text" oninput="search($(this).val())" placeholder="Поиск" class="form-select">
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
        <tbody id="clients">
        @foreach($user->getClients() as $client)
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
                <a href="{{route('clients.show', $client->id)}}" class="btn btn-outline-success">Смотерть</a>
                <a href="{{route('clients.edit', $client->id)}}" class="btn btn-outline-warning">Изменить</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('scripts')

    <input type="hidden" id="currentFilter">
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

            let sort = $(this).data('field');
            let orientation = 'DESC';

            let filterInput = $('#currentFilter');
            let filterType = filterInput.data('filter');

            let data;
            if(filterType === 'salon'){
                data = {
                    'salon_id': filterInput.val()
                };
            }

            if(filterType === 'search'){
                data = {
                    'search': filterInput.val()
                }
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
                url: '/clients/'+filterType+'/'+sort+'/'+orientation,
                type: "POST",
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#clients').html(data)
                },
                error: function (request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            });
        });

        function filter(salon_id){
            $('#currentFilter').attr('data-filter', 'salon');
            $('#currentFilter').val(salon_id);

            $.ajax({
                url: '/clients/salon/',
                type: "POST",
                data: {
                  'salon_id': salon_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                     $('#clients').html(data)
                },
                error: function (request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            });
        }

        function search(query){
            $('#currentFilter').attr('data-filter', 'search');
            $('#currentFilter').val(query);

            $.ajax({
                url: '/clients/search/',
                type: "POST",
                data: {
                    'search': query
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#clients').html(data)
                },
                error: function (request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            });
        }

        function getContact(client_id){
            $.ajax({
                url: 'clients/'+client_id+'/get-contact',
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
