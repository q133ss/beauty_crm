@extends('layouts.app')
@section('title', 'Записи')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
    <div class="row col">
        <a href="{{route('records.create')}}" class="btn btn-success" style="align-self: center">Добавить</a>

        <div class="col" style="align-self: center">
            <select name="" style="align-self: center" onchange="filter($(this).val())" class="form-control" id="">
                <option value="1" selected>Необработанные</option>
                <option value="processed">Обработанные</option>
                <option value="2">Подтвержденные</option>
                <option value="3">Откланенные</option>
                <option value="all">Все</option>
            </select>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>№</th>
            <th>Клиент</th>
            <th>Дата</th>
            <th>Время</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody id="records">
        @foreach($records as $record)
        <tr>
            <td>{{$record->id}}</td>
            <td><a href="#">{{$record->client->name}}</a></td>
            <td>{{$record->date}}</td>
            <td>{{$record->time->time}}</td>
            <td>
                @if($record->status == 'confirmed')
                    <label class="badge badge-success">Подтвержден</label>
                @elseif($record->status == 'rejected')
                    <label class="badge badge-danger">Отклонен</label>
                @else
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
@endsection
@section('scripts')
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
                },
                error: function(request, status, error) {
                    //console.log(statusCode = request.responseText);
                }
            })
        }
    </script>
@endsection
