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
    </tr>
@endforeach
