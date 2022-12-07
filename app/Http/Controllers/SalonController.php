<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalonController\AddUserRequest;
use App\Models\Day;
use App\Models\Salon;
use App\Models\User;
use App\Services\Salons\SalonService;
use Illuminate\Http\Request;

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
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'post' => $user->getSalonPost($salon_id)
        ];
        return $data;
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
