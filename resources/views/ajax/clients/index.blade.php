@foreach($clients as $client)
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
