@extends('layouts.app')
@section('title', 'База клиентов')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
    <div class="row col">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            На этой странице отображен список всех активных клиентов.
            Клиенты которые давно не пользовались вашими услугами находятся в разделе
            <a href="#">Спящие клиенты</a>
        </div>
        <a href="{{route('clients.create')}}" class="btn btn-sm btn-success" style="align-self: center">Добавить</a>

        <div class="col" style="align-self: center">
            <select name="" style="align-self: center" onchange="salonFilter($(this).val())" class="form-control" id="">
                <option value="" id="salon-filter" disabled selected>Салон</option>
                @foreach($salons as $salon)
                    <option value="{{$salon->id}}">{{$salon->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col" style="align-self: center">
            <select name="" style="align-self: center" onchange="clientFilter($(this).val())" class="form-control" id="">
                <option value="" id="client-filter" disabled selected>Клиент</option>
                @foreach($clients as $client)
                    <option value="{{$client->id}}">{{$client->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col" style="align-self: center">
            <input type="text" id="search" placeholder="Поиск" style="border: 0" class="form-control-sm" oninput="search($(this).val())">
        </div>
    </div>
    <table class="table">
        <thead>
        <tr class="clients-table_header">
            <th>№</th>
            <th>Фото</th>
            <th>Имя</th>
            <th>Салон</th>
            <th>Дата последнего заказа</th>
            <th>Контакты</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody id="records">
        @foreach($clients as $client)
            <tr>
                <td>{{$client->id}}</td>
                <td><img src="{{$client->avatar()}}" width="100px" alt=""></td>
                <td>{{$client->name}}</td>
                <td>
                    <a href="#">{{$client->lastOrderSalon() ? $client->lastOrderSalon()->name : 'Ошибка'}}</a>
                </td>
                <td>{{mb_substr($client->lastOrder()->created_at,0,16)}}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary" onclick="getContacts('{{$client->id}}')" data-toggle="modal" data-target="#contactModal">
                        Смотреть
                    </button>
                </td>
                <td>
                    <a href="{{route('clients.show', $client->id)}}" class="btn btn-info btn-sm">Смотреть</a>
                    <a href="{{route('clients.edit', $client->id)}}" class="btn btn-warning btn-sm">Изменить</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Контакты</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contact-modal">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <style>
        .clients-table_header th{
            cursor: pointer;
        }
    </style>
    <script>
        function salonFilter(salon_id){
            $('#client-filter').prop('selected', true);
            $.ajax({
                url: '/clients/salon/filter/'+salon_id,
                type: "GET",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#records').html(data)
                },
                error: function(request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            });
        }

        function clientFilter(client_id){
            $('#salon-filter').prop('selected', true);
            $.ajax({
                url: '/clients/client/filter/'+client_id,
                type: "GET",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#records').html(data)
                },
                error: function(request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            });
        }

        function getContacts(id){
            $.ajax({
                url: '/clients/'+id+'/contact/',
                type: "GET",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#contact-modal').html(data)
                },
                error: function(request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            });
        }

        $('.clients-table_header>th').click(function (){
            $('.clients-table_header>th').css('font-weight','500');
            $(this).css('font-weight','700');
        });

        function search(request){
            $('#salon-filter').prop('selected', true);
            $('#client-filter').prop('selected', true);
            $.ajax({
                url: '/clients/search/'+request,
                type: "GET",
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#records').html(data)
                },
                error: function(request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            });
        }
    </script>
@endsection
