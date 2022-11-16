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
