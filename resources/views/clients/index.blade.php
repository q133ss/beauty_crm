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
        <a href="{{route('clients.create')}}" class="btn btn-success" style="align-self: center">Добавить</a>

        <div class="col" style="align-self: center">
            <select name="" style="align-self: center" onchange="filter($(this).val())" class="form-control" id="">
                <option value="1">Необработанные</option>
                <option value="processed">Обработанные</option>
                <option value="2">Подтвержденные</option>
                <option value="3">Отклоненные</option>
                <option value="all">Все</option>
            </select>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
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
                    <a href="#">{{$client->lastOrderSalon()->name}}</a>
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
    <script>
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
            })
        }
    </script>
@endsection
