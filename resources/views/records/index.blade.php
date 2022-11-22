@extends('layouts.app')
@section('title', 'Записи')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
    <div class="row col">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            На этой странице отображены все заявки от клиентов на ваши услуги.
            Вы можете воспользоваться поиском, а также отфильтровать и отсортировать их
        </div>
        <a href="{{route('records.create')}}" class="btn btn-success" style="align-self: center">Добавить</a>

        <div class="col" style="align-self: center">
            <select name="" style="align-self: center" onchange="filter($(this).val())" class="form-control" id="">
                <option value="1" @if($filter == 1) selected @endif>Необработанные</option>
                <option value="processed">Обработанные</option>
                <option value="2" @if($filter == 2) selected @endif>Подтвержденные</option>
                <option value="3">Отклоненные</option>
                <option value="all">Все</option>
            </select>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr class="clients-table_header">
            <th data-sort="id">№ <div class="table-sort"><i class="fa fa-arrow-up"></i><i class="fa fa-arrow-down"></i></div></th>
            <th data-sort="client">Клиент <div class="table-sort"><i class="fa fa-arrow-up"></i><i class="fa fa-arrow-down"></i></div></th>
            <th data-sort="data">Дата <div class="table-sort"><i class="fa fa-arrow-up"></i><i class="fa fa-arrow-down"></i></div></th>
            <th data-sort="time">Время <div class="table-sort"><i class="fa fa-arrow-up"></i><i class="fa fa-arrow-down"></i></div></th>
            <th data-sort="status">Статус <div class="table-sort"><i class="fa fa-arrow-up"></i><i class="fa fa-arrow-down"></i></div></th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody id="records">
        @foreach($records as $record)
        <tr>
            <td>{{$record->id}}</td>
            <td><a href="{{route('clients.show', $record->client->id)}}">{{$record->client->name}}</a></td>
            <td>{{$record->getDate()}}</td>
            <td>{{$record->timeFormatted()}}</td>
            <td>
                    @if($record->status->name == 'confirmed')
                        <label class="badge badge-success">Подтвержден</label>
                    @elseif($record->status->name == 'rejected')
                        <label class="badge badge-danger">Отклонен</label>
                    @elseif($record->status->name == 'not_processed')
                        <label class="badge badge-info">Не обработан</label>
                    @endif
            </td>
            <td>
                <a href="{{route('records.show', $record->id)}}" class="btn btn-info btn-sm">Смотреть</a>
                <a href="{{route('records.edit', $record->id)}}" class="btn btn-warning btn-sm">Изменить</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <input type="hidden" id="filter-input">
@endsection
@section('scripts')
    <style>
        .clients-table_header th{
            cursor: pointer;
        }

        .table-sort{
            display: grid;
            float: right;
            font-size: 8px;
        }
    </style>
    <script>
        function filter(field){
            $.ajax({
                url: '/records/filter/',
                type: "POST",
                data: {
                    field:field
                },
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#records').html(data)
                    $('#filter-input').val(field)
                },
                error: function(request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            });
        }

        let lastField = '';
        let orientation = 'ASC';

        $('.clients-table_header>th').click(function (){
            let sort = $(this).data('sort');
            let field = $('#filter-input').val();

            //Выделение сортировки
            $('.clients-table_header>th').find('i').css('color','#666666');
            $(this).css('font-weight','700');

            //Проверяем на ASC/DESC
            if(lastField !== sort){
                lastField = sort;
                orientation = 'ASC';
                $(this).find('i.fa-arrow-up').css('color', '#ec37fc')
            }else{
                if(orientation === 'DESC') {
                    orientation = 'ASC';
                    $(this).find('i.fa-arrow-down').css('color', '#666666')
                    $(this).find('i.fa-arrow-up').css('color', '#ec37fc')
                }else{
                    orientation = 'DESC';
                    $(this).find('i.fa-arrow-down').css('color', '#ec37fc')
                    $(this).find('i.fa-arrow-up').css('color', '#666666')
                }
            }

            url_path = '/records/sort/' + field + '/' + sort + '/' + orientation;

            if(field === '' || field === undefined){
                url_path = '/records/sort/1/' + sort + '/' + orientation;
            }

            $.ajax({
                url: url_path,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#records').html(data)
                    $('#filter-input').val(field)
                },
                error: function (request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            });
        });
    </script>
@endsection
