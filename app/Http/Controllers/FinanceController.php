<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinanceController\StoreRequest;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomeArr = \App\Models\Income::groupByMonth(Auth()->id())->toArray();
        return view('finances.index', compact('incomeArr'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->has('type') && ($request->type == 'incomes' || $request->type == 'expenses')){
            if($request->type == 'incomes'){
                $title = 'доход';
            }else{
                $title = 'расход';
            }
            return view('finances.create', ['type' => $request->type, 'title' => $title]);
        }else{
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        unset($data['finance_type']);
        $data['user_id'] = Auth()->id();

        if($request->finance_type == 'income'){
            Income::create($data);
            $message = 'Доход успешно добавлен';
        }else{
            Expense::create($data);
            $message = 'Расход успешно добавлен';
        }
        return to_route('finances.index')->withSuccess($message);
    }


    public function detail($type)
    {
        if($type == 'incomes'){
            $data = Auth()->user()->incomes;
            $title = 'Доходы';
        }else{
            $data = Auth()->user()->expenses;
            $title = 'Расходы';
        }

        return view('finances.detail', compact('data','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
