@foreach($records as $record)
    <tr>
        <td>{{$record->id}}</td>
        <td><a href="{{route('clients.show', $record->client->id)}}">{{$record->client->name}}</a></td>
        <td>{{$record->date}}</td>
        <td>{{$record->timeFormatted()}}</td>
        <td>
            @if($record->status->name == 'confirmed')
                <label class="badge badge-success">Подтвержден</label>
            @elseif($record->status->name == 'rejected')
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
