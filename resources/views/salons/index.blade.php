@extends('layouts.app')
@section('title', 'Салоны')
@section('content')
    <div class="alert alert-info">На этой странице отображены все ваши салоны.
        Вы можете изменить информацию о них, настроить, а так же закрыть</div>
    <table class="table mt-3">
        <thead>
        <tr class="sort-table-header">
            <th class="sort-col" data-field="id">
                №
            </th>
            <th class="sort-col" data-field="client">
                Название
            </th>

            <th>
                Просмотр
            </th>
        </tr>
        </thead>
        <tbody id="salons">
        @foreach($salons as $salon)
            <tr>
                <td>
                    {{$salon->id}}
                </td>
                <td>
                   {{$salon->name}}
                </td>
                <td>
                    <a class="btn btn-outline-info btn-fw" href="{{route('salons.show', $salon->id)}}">Смотреть</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
