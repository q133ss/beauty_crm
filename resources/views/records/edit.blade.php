@extends('layouts.app')
@section('title', 'Просмотр записи')
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
    <form action="{{route('records.update', $record->id)}}" method="POST" class="d-inline">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Дата</label>
            <input type="text" class="form-control form-control-sm date-input" value="{{$record->getDate()}}" placeholder="" name="date">
        </div>

        <div class="form-group">
            <label>Время</label>
            <input type="time" name="time" value="{{$record->timeFormatted()}}" class="form-control form-control-sm">
        </div>

        <div class="form-group">
            <label>Услуга</label>
            <input type="text" name="service_id" class="form-control form-control-sm" placeholder="Пока что так))">
        </div>
        <button class="btn btn-info">Сохранить</button>
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
                var m = date.getMonth() + 1; //Month from 0 to 11
                var y = date.getFullYear();
                input.value = '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
            }
        })
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
@endsection
