@extends('layouts.app')
@section('title', 'Изменить салон')
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('content')
    <form action="{{route('salons.update', $salon->id)}}" method="POST">
        @method('PUT')
        @csrf
        <div class="bg-white rounded p-4">
                <h3>Настройки салона</h3>
                <div class="form-group">
                    <label for="name">Название</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$salon->name}}">
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
                                        <div class="form-group">
                                            <label for="start">Начало рабочего дня</label>
                                            <input type="time" value="{{$salon->workTime->where('day_id',$day->id)->pluck('start')->first()}}" class="form-control" name="start_time-{{$day->id}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="start">Конец рабочего дня</label>
                                            <input type="time" value="{{$salon->workTime->where('day_id',$day->id)->pluck('end')->first()}}" class="form-control" name="end_time-{{$day->id}}">
                                        </div>

                                        <div class="form-group" id="breakWrap-{{$day->id}}">
                                            <label for="start">Перерыв</label>
                                            <div class="text-danger mb-2" id="break_error-{{$day->id}}"></div>
                                            @if(!empty(json_decode($salon->workTime->where('day_id',$day->id)->pluck('breaks')->first())))
                                                @foreach(json_decode($salon->workTime->where('day_id',$day->id)->pluck('breaks')->first()) as $break)
                                                    @php
                                                        $uid = $day->id.uniqid().uniqid();
                                                    @endphp
                                                    <div class="input-group mb-3" id="break_{{$uid}}">
                                                        <input type="time" name="start_break" value="{{collect(explode('-',$break))->first()}}" class="form-control" placeholder="Начало перерыва">
                                                        <input type="time" name="stop_break" value="{{collect(explode('-',$break))->last()}}" class="form-control" placeholder="Конец перерыва">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-danger" type="button" onclick="removeBreak('{{$uid}}', '{{$day->id}}')">Удалить</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
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
                @foreach($salon->employees as $employee)
                    <tr>
                        <td>{{$employee->name}}</td>
                        <td>{{$employee->getSalonPost($salon->id)}}</td>
                        <td>
                            <button onclick="editEmployees('{{$employee->id}}')" type="button" class="btn btn-outline-info">Изменить</button>
                            <button onclick="deleteEmployee('{{$employee->id}}')" type="button" class="btn btn-outline-danger">Удалить</button>
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
        $('#prepayment').click(function (){
            if($(this).prop('checked')){
                $('#percent_block').show()
            }else{
                $('#percent_block').hide()
            }
        });

        let breakCounter = 0;
        function addBreak(day_id){
            breakCounter++;
            $('#breakWrap-'+day_id).append(
                '<div class="input-group mb-3" id="break_'+breakCounter+'">'+
                    '<input type="time" name="start_break" class="form-control" placeholder="Начало перерыва">'+
                    '<input type="time" name="stop_break" class="form-control" placeholder="Конец перерыва">'+
                    '<div class="input-group-append">'+
                        '<button class="btn btn-outline-warning" type="button" onclick="saveBreak('+breakCounter+', '+day_id+')">Сохранить</button>'+
                    '</div>'+
                '</div>'
            );
        }

        function removeBreak(number, day_id){
            let breakRow = $('#break_'+number);
            let start = breakRow.find('input[name="start_break"]').val();
            let stop = breakRow.find('input[name="stop_break"]').val();
            if(confirm('Подтвердите')){
                $.ajax({
                    url: '/salons/{{$salon->id}}/'+day_id+'/remove-break',
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                      'start':start,
                      'stop':stop
                    },
                    success: (data) => {
                        breakRow.remove()
                    },
                    error: function (err) {
                        //
                    }
                });
            }else{
                return false;
            }
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
                    $('#edit_post > option').removeAttr('selected');
                    $('#edit_name').val(data.name);
                    $('#edit_phone').val(data.phone);
                    $('#edit_email').val(data.email);
                    $('#edit_post > option:contains("'+data.post+'")').attr("selected", "selected");
                    $('#user-btn').attr('onclick', 'updateUser('+data.id+')');
                    $('#employmentEditModal').modal('show');
                },
                error: function (err) {
                    //
                }
            });
        }

        function updateEmployees(){
            $.ajax({
                url: '/salons/update/employees/{{$salon->id}}',
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('#employee-table').html(data);
                },
                error: function (err) {
                    //
                }
            });
        }

        function updateUser(user_id){
            let name = $('#edit_name').val();
            let phone = $('#edit_phone').val();
            let email = $('#edit_email').val();
            let post_id = $('#edit_post').val();

            $.ajax({
                url: '/salons/update-usr/'+user_id,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'name': name,
                    'phone': phone,
                    'email': email,
                    'post_id': post_id,
                    'salon_id': {{$salon->id}}
                },
                success: (data) => {
                    updateEmployees();
                    $('#employmentEditModal').modal('hide');
                },
                error: function (err) {
                    //
                }
            });
        }

        function deleteEmployee(user_id){
            if(confirm('Вы уверены?')){
                $.ajax({
                    url: '/salons/delete/employee/'+user_id+'/{{$salon->id}}',
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        updateEmployees();
                    },
                    error: function (err) {
                        //
                    }
                });
            }else{
                return false;
            }
        }

        function saveBreak(breakCounter, day_id){
            let breakRow = $('#break_'+breakCounter);
            let start = breakRow.find('input[name="start_break"]').val();
            let stop = breakRow.find('input[name="stop_break"]').val();

            $.ajax({
                url: '/salons/{{$salon->id}}/'+day_id+'/add-break',
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'start': start,
                    'stop': stop
                },
                success: (data) => {
                    breakRow.find('button').removeClass('btn-outline-warning');
                    breakRow.find('button').addClass('btn-outline-danger');
                    breakRow.find('button').html('Удалить');
                    breakRow.find('button').attr('onclick', 'removeBreak('+breakCounter+')');
                },
                error: function (err) {
                    $.each(err.responseJSON.errors, function (key, value) {
                        $('#break_error-'+day_id).html(value[0]);
                    });
                }
            });
        }
    </script>

    <script src="/js/jquery.mask.min.js"></script>
    <script>
        $('#user_phone').mask('+7(000)000-00-00')
        $('#edit_phone').mask('+7(000)000-00-00')
    </script>
@endsection
