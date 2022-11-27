@extends('layouts.app')
@section('title', 'Просмотр клиента')
@section('content')
<div class="bg-white rounded p-4">
    <h3>Фото</h3>
    <img src="{{$client->avatar()}}" style="max-width: 300px" alt=""> <br>
    <h3 class="mt-3">Контакты</h3>
    <table class="table table-bordered mb-4">
        <tbody>
        <tr>
            <td>
                Имя
            </td>
            <td>
                {{$client->name}}
            </td>
        </tr>

        @if($client->socials())
        @foreach($client->socials() as $key => $social)
            <tr>
                <td>
                    {{$key}}
                </td>
                <td>
                    {{$social}}
                </td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>

    <h3>Заметка</h3>
    <blockquote class="blockquote"><p class="mb-0">{{$client->note}}</p></blockquote>
    <button class="btn btn-outline-info btn-fw">Связаться с клиентом</button>
    <a href="{{route('orders.create', 'user='.$client->id)}}" class="btn btn-outline-primary btn-fw">Создать запись</a>

    <h3 class="mt-4">Статистика</h3>

    <table class="table table-bordered">
        <tbody>
        <tr>
            <td>
                <i class="fa fa-rub text-primary"></i>
                Клиент оплатил услуг на:
            </td>
            <td>
                {{Auth()->user()->getClientSum($client->id, 'price')}}
                ₽
            </td>
        </tr>

        <tr>
            <td>
                <i class="fa fa-hourglass-end text-primary"></i>
                Время затраченное на клиента:
            </td>
            <td>
                {{Auth()->user()->getSumWorkTime($client->id)}}
                ч
            </td>
        </tr>
        </tbody>
    </table>

    <div class="card-body">
        <canvas id="barChart"></canvas>
    </div>

    <h3 class="mt-4">История заказов</h3>

    <table class="table">
        <thead>
        <tr>
            <th>Дата</th>
            <th>Услуга</th>
            <th>Цена</th>
            <th>Время</th>
        </tr>
        </thead>
        <tbody>
        @foreach($client->orders->sortBy('id', SORT_NUMERIC) as $order)
            <tr>
                <td>{{$order->getDate()}} в {{$order->time}}</td>
                <td><a href="#">{{$order->service->name}}</a></td>
                <td>{{$order->price}}</td>
                <td>
                    {{$order->work_time}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
@section('scripts')
    <script src="/vendors/base/vendor.bundle.base.js"></script>

    <script>

        var data = {
            labels: [
                @foreach($client->orders as $order)
                '{{$order->getDate()}}',
                @endforeach
            ],
            datasets: [{
                label: '₽',
                data: [
                    @foreach($client->orders as $order)
                        '{{$order->price}}',
                    @endforeach
                ],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                fill: false
            }]
        };

        var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend: {
                display: false
            },
            elements: {
                point: {
                    radius: 0
                }
            }

        };

        if ($("#barChart").length) {
            var barChartCanvas = $("#barChart").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: data,
                options: options
            });
        }
    </script>

@endsection
