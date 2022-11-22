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
@if($clients->isEmpty())
    <h5>Ничего не найдено</h5>
@endif
