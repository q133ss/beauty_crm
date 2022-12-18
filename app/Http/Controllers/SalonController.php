<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalonController\AddBreakRequest;
use App\Http\Requests\SalonController\AddUserRequest;
use App\Http\Requests\SalonController\ChangeWorkTimeRequest;
use App\Http\Requests\SalonController\UpdateRequest;
use App\Http\Requests\SalonController\UpdateUserRequest;
use App\Models\Day;
use App\Models\Salon;
use App\Models\User;
use App\Models\WorkTime;
use App\Services\Salons\SalonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth()->user();
        if($user->is_salon == true){
            $salons = $user->salons;
            return view('salons.index', compact('salons'));
        }else{
            #Если частник
            echo 'Ты часник))';
            //то показываем ему show/salon_id, там будет кнопка изменить
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salon = Salon::findOrFail($id);
        $days = Day::get();
        $posts = Auth()->user()->getStuffPosts();
        return view('salons.show', compact('salon','days', 'posts'));
    }

    public function addUser(AddUserRequest $request)
    {
        return SalonService::addUser($request->validated());
    }

    public function getUser($salon_id, $user_id)
    {
        $user = User::findOrFail($user_id);
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'post' => $user->getSalonPost($salon_id)
        ];
        return $data;
    }

    public function updateEmployees($salon_id)
    {

        if(Auth()->user()->checkSalon($salon_id)){
            $salon = Salon::findOrFail($salon_id);
            return view('ajax.salons.employees', compact('salon'));
        }else{
            abort(403);
        }
    }

    public function updateUser($user_id, UpdateUserRequest $request)
    {
        unset($request->validated()['salon_id']);
        $user = User::findOrFail($user_id);
        if($user->checkSalon($request->salon_id)) {
            $user->update($request->validated());
            return true;
        }else{
            abort(403);
        }
    }

    public function addBreak(AddBreakRequest $request, $salon_id, $day_id)
    {
        if(Auth()->user()->checkSalon($salon_id)){
            $workTime = WorkTime::where('salon_id', $salon_id)->where('day_id', $day_id)->first();
            if(isset($workTime->breaks)) {
                $breaks = json_decode($workTime->breaks);
                array_push($breaks, $request->start.'-'.$request->stop);
                $workTime->breaks = json_encode($breaks);
            }else{
                $breaks = $request->start.'-'.$request->stop;
                $workTime->breaks = json_encode($breaks);
            }
            $workTime->save();
        }
        return true;
    }

    public function removeBreak(Request $request, $salon_id, $day_id)
    {
        if(Auth()->user()->checkSalon($salon_id)) {
            $workTime = WorkTime::where('salon_id', $salon_id)->where('day_id', $day_id)->first();
            $breaks = json_decode($workTime->breaks);
            $key = array_search($request->start.'-'.$request->stop, $breaks);
            unset($breaks[$key]);
            $workTime->breaks = json_encode($breaks);
            $workTime->save();
        }else{
            abort(403);
        }
        return true;
    }

    public function deleteEmployee($user_id, $salon_id)
    {
        abort_if(!Auth()->user()->checkSalon($salon_id), 403);

        $user = User::find($user_id); ///salon id
        if($user->checkSalon($salon_id)){
            DB::table('user_salon')->where('user_id', $user_id)->where('salon_id', $salon_id)->delete();
        }else{
            abort(403);
        }
    }

    function changeWorkTime(ChangeWorkTimeRequest $request, $salon_id, $day_id){
        if(Auth()->user()->checkSalon($salon_id)){
            $workTime = WorkTime::where('salon_id', $salon_id)->where('day_id', $day_id)->first();
            $workTime->start = $request->start;
            $workTime->end = $request->end;
            $workTime->save();
        }else{
            abort(403);
        }
        return true;
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
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        if($request->prepayment != 'on'){
                $data['percent'] = 0;
        }

        $salon = Salon::findOrFail($id);
        if(Auth()->user()->checkSalon($id)){
            $salon->update($data);
        }else{
            abort(403);
        }
        return to_route('salons.index')->withSuccess('Салон успешно обновлен');
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
