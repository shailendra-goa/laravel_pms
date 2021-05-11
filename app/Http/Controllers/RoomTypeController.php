<?php

namespace App\Http\Controllers;

use App\room_type;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $room_types = room_type::all();
        dd($transactions);

        return view('book_room')->with([
           '$room_types' => $room_types 
        ]);
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
     * @param  \App\room_type  $room_type
     * @return \Illuminate\Http\Response
     */
    public function show(room_type $room_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\room_type  $room_type
     * @return \Illuminate\Http\Response
     */
    public function edit(room_type $room_type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\room_type  $room_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, room_type $room_type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\room_type  $room_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(room_type $room_type)
    {
        //
    }
}
