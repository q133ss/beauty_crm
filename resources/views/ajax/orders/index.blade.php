@foreach($orders as $order)
    <tr>
        <td>
            {{$order->id}}
        </td>
        <td>
            <a href="{{route('clients.show', $order->client->id)}}">{{$order->client->name}}</a>
        </td>
        <td>
            <a href="#">{{$order->service->name}}</a>
        </td>
        <td>
            {{$order->getDate()}}
        </td>
        <td>
            {{$order->time}}
        </td>
        <td>
            @if($order->status('code') == 'confirmed')
                <span class="text-primary">{{$order->status('name')}}</span>
            @elseif($order->status('code') == 'rejected')
                <span class="text-danger">{{$order->status('name')}}</span>
            @elseif($order->status('code') == 'not_processed')
                <span class="text-info">{{$order->status('name')}}</span>
            @elseif($order->status('code') == 'waiting_for_payment')
                <span class="text-warning">{{$order->status('name')}}</span>
            @elseif($order->status('code') == 'сompleted')
                <span class="text-success">{{$order->status('name')}}</span>
            @elseif($order->status('code') == 'not_paid')
                <span class="text-danger">{{$order->status('name')}}</span>
            @else
                <span>{{$order->status('name')}}</span>
            @endif
        </td>
        <td>
            <a class="btn btn-outline-info btn-fw" href="#">Смотреть</a>
            <a class="btn btn-outline-warning btn-fw" href="#">Изменить</a>
        </td>
    </tr>
@endforeach
