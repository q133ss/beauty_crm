@extends('layouts.app')
@section('title', 'Добавить запись')
@section('meta')
    <script src="/datepicker/datepicker.min.js"></script>
    <link rel="stylesheet" href="/datepicker/datepicker.min.css">
@endsection
@section('content')
    @if($errors->any())
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach
            </div>
        @endif
    @endif
    <form action="{{route('records.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label>Дата</label>
            <div class="form-control date-input" id="date-text">{{old('date')}}</div>
            <input type="hidden" value="{{old('date')}}" id="date-input" class="form-control form-control-sm" placeholder="" name="date">
        </div>

        <div class="form-group">
            <label>Время</label>
            <input type="time" value="{{old('time')}}" name="time" class="form-control form-control-sm">
        </div>

        <div class="form-group">
            <label for="service">Услуга</label>
            <select name="service_id" class="form-control" id="service">
                @foreach($services as $service)
                    <option value="{{$service->id}}">{{$service->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="salon">Салон</label>
            <select class="form-control" name="salon_id" id="salon">
                @foreach($salons as $salon)
                    <option value="{{$salon->id}}">{{$salon->name}}</option>
                @endforeach
            </select>
        </div>


        <h5>Клиент</h5>

        @if(!\Request::has('user'))
        <div class="form-group">
            <div class="form-check">
                <label for="old_client">
                    <input type="radio" id="old_client" value="old" selected name="choice-client" onchange="changeClientType('old')">
                    Выбрать существующего
                </label>
            </div>
            <label for="new_client">
                <input type="radio" id="new_client" value="new" name="choice-client" onchange="changeClientType('new')">
                Добавить нового
            </label>
        </div>


        <div class="form-group" id="old-client-form">
            <label>Выберите клиента</label>
            <select name="client_id" class="form-control" id="">
                @foreach($clients as $client)
                    <option value="{{$client->id}}">{{$client->name}}</option>
                @endforeach
            </select>
        </div>

        <div id="new-client-form" @if(old('choice-client') != 'new') style="display:none;" @endif>
            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" name="name" class="form-control" value="{{old('name')}}">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{old('email')}}">
            </div>

            <div class="form-group">
                <label for="phone">Телефон</label>
                <input type="text" id="phone-input" placeholder="+7(XXX)XXX-XX-XX" name="phone" class="form-control">
            </div>

            <div class="form-group">
                <label for="tg">Telegram (Не обязательно)</label>
                <input class="form-control" type="text" id="tg" value="{{old('telegram')}}" name="telegram">
            </div>

            <h6>Дополнительные контактные данные</h6>
            <div id="additional-contacts">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="social_name[]" placeholder="Название" aria-label="Название" aria-describedby="basic-addon2">
                    <input type="text" class="form-control" name="social_val[]" placeholder="Ссылка/Номер" aria-label="Ссылка/Номер" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" onclick="addSocial()" type="button">Добавить</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="note">Заметка (Не обязательно)</label>
                <input class="form-control" type="text" id="note" value="{{old('note')}}" name="note">
            </div>
        </div>
        @else
            <span class="form-control">{{App\Models\User::find(\Request('user'))->name}}</span>
            <input type="hidden" name="client_id" value="{{\Request('user')}}">
            <input type="hidden" name="choice-client" value="old">
            <br>
        @endif
        <button class="btn btn-info">Сохранить</button>
    </form>
@endsection
@section('scripts')
    <script src="/js/jquery.mask.min.js"></script>
    <script>
        const picker = datepicker('.date-input', {
            customMonths: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            customDays: ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'],
            overlayPlaceholder: "Год",
            overlayButton: "Готово",
            formatter: (input, date, instance) => {
                var d = date.getDate();
                var m = date.getMonth() + 1; //Month from 0 to 11
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
        });

        function changeClientType(type){
            $('#new-client-form').hide()
            $('#old-client-form').hide()
            console.log('#'+type+'-client-form')
            $('#'+type+'-client-form').show()
        }

        $('#phone-input').mask('+7(000)000-00-00')
    </script>
    <style>
        .qs-datepicker{
            color: #FFFFFF;
        }
        .qs-month-year:hover{
            border-bottom: 1px solid #FFFFFF;
        }
        .qs-controls{
            background-color: #ec37fc;
        }
        .qs-arrow:hover{
            background: rgba(255, 255, 255, 0.4);
        }
        .qs-arrow.qs-left::after{
            border-right-color: #FFFFFF;
        }
        .qs-arrow:hover.qs-right::after{
            border-left-color: #FFFFFF;
        }
        .qs-arrow.qs-right::after{
            border-left-color: #FFFFFF;
        }
        .qs-arrow:hover.qs-left::after{
            border-right-color: #FFFFFF;
        }
        .qs-day{
            color: #FFFFFF;
        }
        .qs-squares{
            background-color: #ec37fc;
        }
        .qs-square:not(.qs-empty):not(.qs-disabled):not(.qs-day):not(.qs-active):hover{
            background: rgba(255, 255, 255, 0.4);
        }
    </style>

    <script src="/js/custom.js"></script>
@endsection
