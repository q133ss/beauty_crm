<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class RecordsController extends Controller
{
    public function index()
    {
        $records = Record::withFilter('is_actual')->get();
        return view('records', compact('records'));
    }

    public function filter(Request $request)
    {
        $records = Record::withFilter($request->field)->get();
        return view('ajax.records.index', compact('records'));
    }
}
