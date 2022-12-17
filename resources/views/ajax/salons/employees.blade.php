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
