@extends('layouts.app')
@section('title', 'Создать заказ')
@section('meta')
    <script src="/datepicker/datepicker.min.js"></script>
    <link rel="stylesheet" href="/datepicker/datepicker.min.css">
    <link rel="stylesheet" href="/css/custom.css">
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form action="{{route('orders.store')}}" class="bg-white rounded p-4" method="POST">
        @csrf
        <div class="form-group">
            <label>Дата</label>
            <div class="form-control form-control-sm date-input" id="date-text">{{date('d-m-Y')}}</div>
            <input type="hidden" id="date-input" class="form-control form-control-sm" placeholder="" name="date">
        </div>

        <div class="form-group">
            <label>Время</label>
            <input type="time" name="time" class="form-control form-control-sm">
        </div>

        <div class="form-group">
            <label for="service">Услуга</label>
            <select name="service_id" class="form-control" id="service">
                @foreach($services as $service)
                    <option value="{{$service->id}}">{{$service->name}}</option>
                @endforeach
            </select>
        </div>

        <label for="#">Клиент</label>

        <div class="form-group">
            <div class="form-check">
                <label for="old" class="form-check-label">
                    <input type="radio" id="old" class="form-check-input" name="client_choose" value="old">
                    Выбрать существующего
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="form-check">
                <label for="new" class="form-check-label">
                    <input type="radio" id="new" class="form-check-input" name="client_choose" value="new">
                    Создать нового
                </label>
            </div>
        </div>

        <div class="form-group">
            <select name="service_id" class="form-control" id="service">
                @foreach($clients as $client)
                    <option value="{{$client->id}}">{{$client->name}}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-outline-primary">Сохранить</button>
    </form>
@endsection
@section('scripts')
    <script>
        const picker = datepicker('.date-input', {
            customMonths: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            customDays: ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'],
            overlayPlaceholder: "Год",
            overlayButton: "Готово",
            formatter: (input, date, instance) => {
                var d = date.getDate();
                var m = date.getMonth() + 1;
                var y = date.getFullYear();
                input.value = '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
            },
            onSelect: (instance, date) => {
                var d = date.getDate();
                var m = date.getMonth() + 1; //Month from 0 to 11
                var y = date.getFullYear();
                $('#date-text').text('' + (d <= 9 ? '0' + d : d) + '-' + (m<=9 ? '0' + m : m) + '-' + y);
                $('#date-input').val('' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d));
            }
        })
    </script>
@endsection
