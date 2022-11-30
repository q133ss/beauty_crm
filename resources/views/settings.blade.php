@extends('layouts.app')
@section('title', 'Настройки')
@section('content')
    <div class="bg-white rounded p-4">
        <h3>Основное</h3>
        <form action="#">
            <div class="form-group">
                <label for="sleep" data-toggle="tooltip" data-placement="top" title="По истечении какого количества дней клиент перейдет в список «спящих» клиентов">Количество дней, когда клиент станет "спящим"</label>
                <input type="text" value="" class="form-control" name="sleep_time" id="sleep">
            </div>

            <div class="form-group">
                <label for="tg" data-toggle="tooltip" data-placement="top" title="Этот текст будет отправлен «спящим» клиентам в Telegram, при отправке уведомления">Текст уведомления для спящих клиентов в Telegram</label>
                <textarea name="telegram_text" id="tg" cols="30" rows="10" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="push" data-toggle="tooltip" data-placement="top" title="Этот текст придет в виде уведомления на телефон «спящим» клиентам, при отправке уведомления">Текст для пуша</label>
                <input type="text" value="" class="form-control" name="push_text" id="push">
            </div>

            <div class="form-group">
                <label for="nick" data-toggle="tooltip" data-placement="top" title="Указанному пользователю будут приходить сообщения в Telegram о новых заказах">Ваш ник в Telegram</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="@username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="button">Проверить</button>
                    </div>
                </div>
            </div>
            <button class="btn btn-outline-primary" type="submit">Сохранить</button>
        </form>
    </div>

    <div class="bg-white rounded p-4 mt-4">
        <form action="#">
            <h3>Аккаунт</h3>

            <div class="form-group">
                <label for="name">Имя</label>
                <input type="text" id="name" class="form-control" name="name" value="{{Auth()->user()->name}}">
            </div>

            <div class="form-group">
                <label for="phone">Телефон</label>
                <input type="text" id="phone" class="form-control" name="phone" value="{{Auth()->user()->phone}}">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" name="email" value="{{Auth()->user()->email}}">
            </div>
            <button type="submit" class="btn btn-outline-primary">Сохранить</button>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
