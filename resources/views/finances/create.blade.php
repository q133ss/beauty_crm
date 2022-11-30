@extends('layouts.app')
@section('title', 'Добавить '.$title)
@section('meta')
    <script src="/datepicker/datepicker.min.js"></script>
    <link rel="stylesheet" href="/datepicker/datepicker.min.css">
    <link rel="stylesheet" href="/css/custom.css">
@endsection
@section('content')
    <h3>Добавить {{$title}}</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <div class="bg-white rounded p-4 mt-4">
        @if($type == 'incomes')
            <form action="{{route('finances.store')}}" method="POST">
                @csrf
                <input type="hidden" name="finance_type" value="income">
                <div class="form-group">
                    <label for="type">Тип</label>
                    <select name="type" id="" class="form-control">
                        <option value="Продажа услуги" @if(old('type') == 'Продажа услуги') selected @endif>Продажа услуги</option>
                        <option value="Другое" @if(old('type') == 'Другое') selected @endif>Другое</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sum">Сумма</label>
                    <input type="text" id="sum" class="form-control" name="sum" value="{{old('sum')}}">
                </div>

                <div class="form-group">
                    <label for="date">Дата</label>
                    <div class="form-control form-control-sm date-input" id="date-text">{{date('d-m-Y')}}</div>
                    <input type="hidden" id="date" class="form-control" name="date" value="{{old('date')}}">
                </div>

                <button class="btn btn-outline-primary">Добавить</button>
            </form>
        @else
            <form action="{{route('finances.store')}}" method="POST">
                @csrf
                <input type="hidden" name="finance_type" value="expense">
                <div class="form-group">
                    <label for="type">Тип</label>
                    <select name="type" id="" class="form-control">
                        <option value="аренда" @if(old('type') == 'аренда') selected @endif>Аренда</option>
                        <option value="материалы" @if(old('type') == 'материалы') selected @endif>Материалы</option>
                        <option value="курсы" @if(old('type') == 'курсы') selected @endif>Курсы</option>
                        <option value="Другое" @if(old('type') == 'Другое') selected @endif>Другое</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sum">Сумма</label>
                    <input type="text" id="sum" class="form-control" name="sum" value="{{old('sum')}}">
                </div>

                <div class="form-group">
                    <label for="date">Дата</label>
                    <div class="form-control form-control-sm date-input" id="date-text">{{date('d-m-Y')}}</div>
                    <input type="hidden" id="date" class="form-control" name="date" value="{{old('date')}}">
                </div>

                <button class="btn btn-outline-primary">Добавить</button>
            </form>
        @endif
    </div>
@endsection
@section('scripts')
    <script src="/js/custom.js"></script>
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
                $('#date').val('' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d));
            }
        })
    </script>
@endsection
