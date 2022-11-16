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
                <option value="is_actual" selected>Только новые</option>
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
                @if($record->isView())
                    <label class="badge badge-info">Просмотрена</label>
                @else
                    <label class="badge badge-success">Новая</label>
                @endif
            </td>
            <td>
                <a href="{{route('records.show', $record->id)}}" class="btn btn-info btn-sm">Смотреть</a>
                <a href="{{route('records.edit', $record->id)}}" class="btn btn-info btn-sm">Изменить</a>
                <form action="{{route('records.destroy', $record->id)}}" method="POST" style="display: inline-block">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-info btn-sm">Удалить</button>
                </form>
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
