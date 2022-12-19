@extends('layouts.app')
@section('title', 'Добавить салон')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
    <form action="{{route('salons.store')}}" method="POST">
        @csrf
        <div class="bg-white rounded p-4">
            <h3>Настройки салона</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" class="form-control" id="name" name="name" value="">
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
            </div>

            <div class="form-group">
                <div class="form-check form-check-primary">
                    <label class="form-check-label">
                        <input type="checkbox" name="prepayment" id="prepayment" class="form-check-input" checked="">
                        Предоплата
                        <i class="input-helper"></i></label>
                </div>
            </div>

            <div class="form-group" id="percent_block">
                <label for="percent">Процент предоплаты</label>
                <input type="text" class="form-control" name="percent" id="percent">
            </div>

            <div class="form-group">
                <label for="status">Статус</label>
                <select name="status" id="status" class="form-control">
                    <option value="1" selected>Открыт</option>
                    <option value="0">Закрыт</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded p-4 mt-2">
            <h3>Рабочее время</h3>
            <div class="form-group">
                <label for="days">Вы можете настроить рабочее время для каждого дня</label>
                <div id="days">
                    <div id="accordion">
                        @foreach($days as $day)
                            <div class="card">
                                <div class="card-header" id="heading-{{$day->id}}">
                                    <h5 class="mb-0">
                                        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapse-{{$day->id}}" aria-expanded="true" aria-controls="collapse-{{$day->id}}">
                                            {{$day->name}}
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapse-{{$day->id}}" class="collapse" aria-labelledby="heading-{{$day->id}}" data-parent="#accordion">
                                    <div class="card-body">
                                        <h5>{{$day->name}}</h5>
                                        <div class="text-danger" id="day_error_{{$day->id}}"></div>
                                        <div class="form-group">
                                            <label for="start">Начало рабочего дня</label>
                                            <input type="time" id="day_start_time-{{$day->id}}" onchange="timeSave('{{$day->id}}')" class="form-control" name="start_time-{{$day->id}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="start">Конец рабочего дня</label>
                                            <input type="time" id="day_stop_time-{{$day->id}}" onchange="timeSave('{{$day->id}}')" class="form-control" name="end_time-{{$day->id}}">
                                        </div>

                                        <div class="form-group" id="breakWrap-{{$day->id}}">
                                            <label for="start">Перерыв</label>
                                            <div class="text-danger mb-2" id="break_error-{{$day->id}}"></div>
                                        </div>
                                        <button class="btn btn-outline-secondary" onclick="addBreak('{{$day->id}}')" type="button">Добавить</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-white p-4 rounded mt-2">
            <h3>Сотрудники</h3>
            <table class="table">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Должность</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody id="employee-table">

                </tbody>
            </table>
            <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#employmentModal">Добавить сотрудника</button>
        </div>
        <button type="submit" class="btn btn-outline-primary mt-4">Сохранить</button>
        <div class="display-n" id="stuffs"></div>
    </form>
    {{--    Добавить сотрудника--}}
    <div class="modal fade" id="employmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить сотрудника</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="error text-danger d-none" id="employee_error"></span>
                    <div class="form-group">
                        <label for="user_name">Имя</label>
                        <input type="text" id="user_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_phone">Телефон</label>
                        <input type="text" id="user_phone" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_phone">Email</label>
                        <input type="text" id="user_email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_post">Должность</label>
                        <select id="user_post" class="form-control">
                            @foreach($posts as $post)
                                <option value="{{$post->id}}">{{$post->name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="addUser()" class="btn btn-primary">Добавить</button>
                </div>
            </div>
        </div>
    </div>

    {{--    Edit user--}}
    <div class="modal fade" id="employmentEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Изменить сотрудника</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="error text-danger d-none" id="edit_error"></span>
                    <div class="form-group">
                        <label for="user_name">Имя</label>
                        <input type="text" id="edit_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_phone">Телефон</label>
                        <input type="text" id="edit_phone" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_phone">Email</label>
                        <input type="text" id="edit_email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="edit_post">Должность</label>
                        <select id="edit_post" class="form-control">
                            @foreach($posts as $post)
                                <option value="{{$post->id}}">{{$post->name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="user-btn" onclick="" class="btn btn-primary">Изменить</button>
                </div>
            </div>
        </div>
    </div>
    {{--    end--}}
@endsection
@section('scripts')
    <script>
        let breakCounter = 0;
        function addBreak(day_id){
            breakCounter++;
            $('#breakWrap-'+day_id).append(
                '<div class="input-group mb-3" id="break_'+breakCounter+'">'+
                '<input type="time" name="start_break_'+day_id+'[]" class="form-control" placeholder="Начало перерыва">'+
                '<input type="time" name="stop_break_'+day_id+'[]" class="form-control" placeholder="Конец перерыва">'+
                '<div class="input-group-append">'+
                '<button class="btn btn-outline-danger" type="button" onclick="removeBreak('+breakCounter+')">Удалить</button>'+
                '</div>'+
                '</div>'
            );
        }

        function removeBreak(id){
            $('#break_'+id).remove()
        }

        function addUser(){
            let name = $('#user_name');
            let phone = $('#user_phone');
            let email = $('#user_email');
            let post = $('#user_post');

            name.removeClass('is-invalid');
            phone.removeClass('is-invalid');
            email.removeClass('is-invalid');
            post.removeClass('is-invalid');

            let stuffs = $('#stuffs');

            let name_valid = name.val().length > 0;
            let email_re = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;
            let email_valid = email_re.test(email.val());
            let post_valid = post.val().length > 0;
            let phone_re = /[+]{1}[0-9]{1}[(]{1}[0-9]{3}[)]{1}[0-9]{3}[-]{1}[0-9]{2}[-]{1}[0-9]{2}/;
            let phone_valid = phone_re.test(phone.val());

            let errors = 0;

            if(!name_valid){
                errors++;
                name.addClass('is-invalid');
            }

            if(!phone_valid){
                errors++;
                phone.addClass('is-invalid');
            }

            if(!email_valid){
                errors++;
                email.addClass('is-invalid');
            }

            if(!post_valid){
                errors++;
                post.addClass('is-invalid');
            }

            if(errors == 0) {
                stuffs.append('<input type="hidden" name="stuff_name[]" value="' + name.val() + '">');
                stuffs.append('<input type="hidden" name="stuff_phone[]" value="' + phone.val() + '">');
                stuffs.append('<input type="hidden" name="stuff_email[]" value="' + email.val() + '">');
                stuffs.append('<input type="hidden" name="stuff_post[]" value="' + post.val() + '">');

                $('#employee-table').append(
                    '<tr>'+
                    '<td>'+name.val()+'</td>'+
                    '<td>'+$('#user_post > option[value="'+post.val()+'"]').text()+'</td>'+
                    '<td>'+
                    '<a href="1" class="btn btn-outline-info">Изменить</a>'+
                    '<a href="1" class="btn btn-outline-danger">Удалить</a>'+
                    '</td>'+
                    '</tr>'
                );
                $('#employmentModal').modal('hide')

                name.val('');
                phone.val('');
                email.val('');
                post.val('');
            }
        }
    </script>
    <script src="/js/jquery.mask.min.js"></script>
    <script>
        $('#user_phone').mask('+7(000)000-00-00')
        $('#edit_phone').mask('+7(000)000-00-00')
    </script>
@endsection
