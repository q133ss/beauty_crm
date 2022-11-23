@extends('layouts.app')
@section('title', 'Добавить клиента')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form action="{{route('clients.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" value="{{old('name')}}" id="name" name="name" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" id="email" value="{{old('email')}}" name="email" class="form-control">
        </div>

        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="text" id="phone-input" value="{{old('phone')}}" placeholder="+7(XXX)XXX-XX-XX" name="phone" class="form-control">
        </div>

        <div class="form-group">
            <label for="tg">Telegram (Не обязательно)</label>
            <input class="form-control" type="text" id="tg" value="{{old('telegram')}}" name="telegram">
        </div>

        <div class="form-group">
            <label for="salon">Салон</label>
            <select name="salon_id" id="salon">
                @foreach($salons as $salon)
                    <option value="{{$salon->id}}">{{$salon->name}}</option>
                @endforeach
            </select>
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

            @if(old('social_name'))
                @foreach(old('social_name') as $key => $name)
                    @if($name != '')
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" value="{{$name}}" name="social_name[]" placeholder="Название" aria-label="Название" aria-describedby="basic-addon2">
                        <input type="text" class="form-control" value="{{old('social_val')[$key]}}" name="social_val[]" placeholder="Ссылка/Номер" aria-label="Ссылка/Номер" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-warning" onclick="$(this).parent().parent().remove()" type="button">Удалить</button>
                        </div>
                    </div>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="form-group">
            <label for="note">Заметка</label>
            <input type="text" id="note" value="" name="note" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            Сохранить
        </button>
    </form>
@endsection
@section('scripts')
    <script src="/js/custom.js"></script>
    <script src="/js/jquery.mask.min.js"></script>
    <script>
        $('#phone-input').mask('+7(000)000-00-00')
    </script>
@endsection
