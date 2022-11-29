@extends('layouts.app')
@section('title', 'Финансы')
@section('content')
    <div class="row">
        <div class="col">
            <div class="rounded bg-white p-4">
                <h3 class="text-center">Доходы</h3>
                <ul class="list-group mb-2">
                    @foreach(App\Models\Income::takeLastMonth(Auth()->id())->take(5) as $income)
                    <li class="list-group-item" data-toggle="tooltip" data-placement="top" title="{{$income->type}}"><a href="#" class="d-flex justify-content-between"><span class="text-success">+{{$income->sum}}₽</span> <date>{{$income->getDate()}}</date></a></li>
                    @endforeach
                </ul>
                <a href="#" class="btn btn-outline-success">Добавить доход</a>
                <a href="#" class="btn btn-outline-info">Все доходы</a>
            </div>
        </div>
        <div class="col">
            <div class="rounded bg-white p-4">
                <h3 class="text-center">Расходы</h3>
                <ul class="list-group mb-2">
                    @foreach(App\Models\Expense::takeLastMonth(Auth()->id())->take(5) as $expense)
                    <li class="list-group-item" data-toggle="tooltip" data-placement="top" title="{{$expense->type}}"><a href="#" class="d-flex justify-content-between"><span class="text-danger">-{{$expense->sum}}₽</span> <date>{{$expense->getDate()}}</date></a></li>
                    @endforeach
                </ul>
                <a href="#" class="btn btn-outline-danger">Добавить расход</a>
                <a href="#" class="btn btn-outline-info">Все расходы</a>
            </div>
        </div>
    </div>

    <div class="row bg-white rounded p-4 mt-4">
        <div class="col text-center">
            За последние 30 дней вы заработали: <strong>{{App\Models\Income::takeLastMonth(Auth()->id())->sum('sum')}} </strong> ₽
        </div>

        <div class="col text-center">
            За последние 30 дней вы потратили: <strong>{{App\Models\Expense::takeLastMonth(Auth()->id())->sum('sum')}} </strong> ₽
        </div>
    </div>

    <div class="row p-4 mt-4 bg-white rounded">
        <h3 class="text-center w-100">Статистика за последние 30 дней</h3>
        <div class="col mt-2">
            <h5 class="w-100 text-center">Доходы</h5>
            <canvas id="incomes"></canvas>
        </div>
        <div class="col mt-2">
            <h5 class="w-100 text-center">Расходы</h5>
            <canvas id="expenses"></canvas>
        </div>
    </div>

    <div class="bg-white rounded p-4 mt-4">
        <h3 class="w-100 text-center mb-4">Статистика за все время</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    Месяц
                </th>

                <th>
                    Доходы
                </th>

                <th>
                    Расходы
                </th>
            </tr>
            </thead>
            <tbody>

            @php $incomeCounter = 0; @endphp
            @php $expenseCounter = 0; @endphp
            @foreach($incomeArr as $key => $income)
            <tr>
                <td>
                    {{App\Models\Income::getMonth(mb_substr($key,0,2)). ', ' .mb_substr($key,3,4)}}
                </td>
                <td class="text-success">
                    {{collect($income)->sum('sum')}} ₽

                    @php
                       $incomeCounter++;
                       $current = $key;
                       $keys = array_keys($incomeArr);
                       $ordinal = (array_search($current,$keys)+1)%count($keys);
                       $next = $keys[$ordinal];

                       $nextSum = collect($incomeArr[$next])->sum('sum');
                    @endphp

                    @if($incomeCounter != count($keys))
                        @if(collect($income)->sum('sum') < $nextSum)
                            <i class="fa fa-arrow-down text-warning"></i>
                        @else
                            <i class="fa fa-arrow-up"></i>
                        @endif
                    @endif
                </td>
                <td class="text-danger">
                    @if(array_key_exists($key, App\Models\Expense::groupByMonth(Auth()->id())->toArray()))
                        {{App\Models\Expense::groupByMonth(Auth()->id())[$key]->sum('sum')}} ₽
                        @php
                            $expenseCounter++;
                            $expenseKeys = array_keys(App\Models\Expense::groupByMonth(Auth()->id())->toArray());
                            $expenseOrdinal = (array_search($current,$expenseKeys)+1)%count($expenseKeys);
                            $expenseNext = $expenseKeys[$expenseOrdinal];
                        @endphp
                        @if($expenseCounter != count($expenseKeys))
                            @if(App\Models\Expense::groupByMonth(Auth()->id())[$expenseNext]->sum('sum') < App\Models\Expense::groupByMonth(Auth()->id())[$key]->sum('sum'))
                            <i class="fa fa-arrow-up"></i>
                            @else
                                <i class="fa fa-arrow-down text-warning"></i>
                            @endif
                        @endif
                    @else
                        0 ₽
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    <script src="/vendors/chart.js/Chart.min.js"></script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()

            var incomeData = {
                datasets: [{
                    data: [
                        {{App\Models\Income::takeLastMonth(Auth()->id())->where('type', 'Продажа услуги')->sum('sum')}},
                        {{App\Models\Income::takeLastMonth(Auth()->id())->where('type', 'Другое')->sum('sum')}}
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: [
                    'Продажа услуг',
                    'Другое',
                ]
            };

            var expensesData = {
                //должны получить сумму каждой категории
                datasets: [{
                    data: [
                            {{App\Models\Expense::takeLastMonth(Auth()->id())->where('type', 'аренда')->sum('sum')}},
                            {{App\Models\Expense::takeLastMonth(Auth()->id())->where('type', 'курсы')->sum('sum')}},
                            {{App\Models\Expense::takeLastMonth(Auth()->id())->where('type', 'материалы')->sum('sum')}},
                            {{App\Models\Expense::takeLastMonth(Auth()->id())->where('type', 'другое')->sum('sum')}}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: [
                    'Аренда', 'Материалы', 'Курсы', 'Другое'
                ]
            };

            var doughnutPieOptions = {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            };
            ///
            if ($("#incomes").length) {
                var pieChartCanvas = $("#incomes").get(0).getContext("2d");
                var pieChart = new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: incomeData,
                    options: doughnutPieOptions
                });
            }

            if ($("#expenses").length) {
                var pieChartCanvas = $("#expenses").get(0).getContext("2d");
                var pieChart = new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: expensesData,
                    options: doughnutPieOptions
                });
            }
        });


    </script>
@endsection
