@extends('layouts.app')
@section('title', 'Просмотр клиента')
@section('content')
    <ul class="list-arrow">
        <img src="{{$client->avatar()}}" style="max-width: 300px" alt=""> <br>
        <li>Имя: {{$client->name}}</li>
        @if($client->socials())
            @foreach($client->socials() as $key => $social)
                <li>{{$key}} : {{$social}}</li>
            @endforeach
        @endif
    </ul>
    <button class="btn btn-info">Связаться с клиентом</button>

    <h3 class="mt-3">Статистика</h3>
    <p>
        <i class="fa fa-rub text-primary"></i>
        Клиент оплатил услуг на:
        {{Auth()->user()->getSum($client->id, 'price')}}
        ₽
    </p>

    <p>
        <i class="fa fa-hourglass-end text-primary"></i>
        Время затраченное на клиента:
        {{Auth()->user()->getSumWorkTime($client->id)}}
        ч
    </p>
{{--    Сколько времени затраченно в общем на клиента--}}
{{--    Сколько денег принес клиент--}}
{{--    Графики по времени и дням--}}

    <div class="card-body">
        <h4 class="card-title">График</h4>
        <canvas id="barChart"></canvas>
    </div>

    <h3 class="mt-3">История заказов</h3>

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
