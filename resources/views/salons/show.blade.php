@extends('layouts.app')
@section('title', 'Изменить салон')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
    <form action="#">
        @csrf
        <div class="row">
            <div class="bg-white col rounded p-4">
                <h3>Настройки салона</h3>
                <div class="form-group">
                    <label for="name">Название</label>
                    <input type="text" class="form-control" id="name" value="{{$salon->name}}">
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{$salon->description}}</textarea>
                </div>

                <div class="form-group">
                    <div class="form-check form-check-primary">
                        <label class="form-check-label">
                            <input type="checkbox" name="prepayment" id="prepayment" class="form-check-input" @if($salon->prepayment)checked=""@endif>
                            Предоплата
                            <i class="input-helper"></i></label>
                    </div>
                </div>

                @if($salon->prepayment)
                    <div class="form-group" id="percent_block">
                        <label for="percent">Процент предоплаты</label>
                        <input type="text" class="form-control" name="percent" id="percent" value="{{$salon->percent}}">
                    </div>
                @endif
            </div>

            <div class="bg-white col rounded p-4 ml-2">
                <h3>Рабочее время</h3>
                <div class="form-group">
                    <label for="days">Рабочии дни(выберите дни в которые вы работаете)</label>
                    <div id="days">
                        @foreach($days as $day)
                        <div class="form-check form-check-primary">
                            <label class="form-check-label">
                                <input type="checkbox" name="days[]" value="{{$day->id}}" class="form-check-input">
                                {{$day->name}}
                                <i class="input-helper"></i></label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label for="start">Начало рабочего дня</label>
                    <input type="time" class="form-control" name="start_time">
                </div>

                <div class="form-group">
                    <label for="start">Конец рабочего дня</label>
                    <input type="time" class="form-control" name="end_time">
                </div>

                <div class="form-group" id="breakWrap">
                    <label for="start">Перерыв</label>
                    <div class="input-group mb-3">
                        <input type="text" name="start_break" class="form-control" placeholder="Начало перерыва">
                        <input type="text" name="stop_break" class="form-control" placeholder="Конец перерыва">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" onclick="addBreak()" type="button">Добавить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-white p-4 rounded mt-2">
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
                @foreach($salon->employees as $employee)
                    <tr>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->getSalonPost($salon->id)}}</td>
                        <td>
                            <button onclick="editEmployees('{{$employee->id}}')" type="button" class="btn btn-outline-info">Изменить</button>
                            <a href="#" class="btn btn-outline-danger">Удалить</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#employmentModal">Добавить сотрудника</button>
        </div>
        <button type="submit" class="btn btn-outline-primary mt-4">Сохранить</button>
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
{{--    end--}}
@endsection
@section('scripts')
    <script>
        $('#prepayment').click(function (){
            if($(this).prop('checked')){
                $('#percent_block').show()
            }else{
                $('#percent_block').hide()
            }
        });

        let breakCounter = 0;
        function addBreak(){
            breakCounter++;
            $('#breakWrap').append(
                '<div class="input-group mb-3" id="break_'+breakCounter+'">'+
                    '<input type="text" name="start_break" class="form-control" placeholder="Начало перерыва">'+
                    '<input type="text" name="stop_break" class="form-control" placeholder="Конец перерыва">'+
                    '<div class="input-group-append">'+
                        '<button class="btn btn-outline-danger" onclick="removeBreak('+breakCounter+')" type="button">Удалить</button>'+
                    '</div>'+
                '</div>'
            );
        }

        function removeBreak(number){
            $('#break_'+number).remove()
        }

        function addUser(){
            let name = $('#user_name').val();
            let phone = $('#user_phone').val();
            let email = $('#user_email').val();
            let post_id = $('#user_post').val();

            $.ajax({
                url: '{{route('salons.add.user')}}',
                type: "POST",
                data: {
                  'name': name,
                  'phone': phone,
                  'email':email,
                  'post_id': post_id,
                  'salon_id': {{$salon->id}}
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#employee-table').append(
                        '<tr>'+
                            '<td>'+data.name+'</td>'+
                            '<td>'+data.post+'</td>'+
                            '<td>'+
                                '<a href="'+data.id+'" class="btn btn-outline-info">Изменить</a>'+
                                '<a href="'+data.id+'" class="btn btn-outline-danger">Удалить</a>'+
                            '</td>'+
                        '</tr>'
                    );
                    $('#employmentModal').modal('hide')
                },
                error: function (err) {
                    $.each(err.responseJSON.errors, function (key, value) {
                        $('#employee_error').html(value[0]);
                        $('#employee_error').removeClass('d-none');
                    });
                }
            });
        }

        function editEmployees(id){
            //ajax
            $.ajax({
                url: '/salons/get-usr/{{$salon->id}}/'+id,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#user_post > option').removeAttr('selected');
                    $('#exampleModalLabel').html('Изменить сотрудника');
                    $('#user_name').val(data.name);
                    $('#user_phone').val(data.phone);
                    $('#user_email').val(data.email);
                    $('#user_post > option:contains("'+data.post+'")').attr("selected", "selected");
                    $('#employmentModal').modal('show');
                },
                error: function (err) {
                    //
                }
            });
        }
    </script>

    <script src="/js/jquery.mask.min.js"></script>
    <script>
        $('#user_phone').mask('+7(000)000-00-00')
    </script>
@endsection
