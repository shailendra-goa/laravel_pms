<?php

namespace App\Http\Controllers;

use App\Tariff;
use App\room_type;
use Illuminate\Http\Request;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $room_types = room_type::all();
        return view('add_tariff')->with([
            'room_types' => $room_types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $room_type_ids = $request['room_type_id'];

        for($i=0; $i<count($room_type_ids);$i++)
        {
            $request->validate([
                'from_date'.$room_type_ids[$i] => 'required|date',
                'to_date'.$room_type_ids[$i] => 'required|date|after:from_date'.$room_type_ids[$i],
                'single'.$room_type_ids[$i] => 'required',
                'double'.$room_type_ids[$i] => 'required',
                'extra_adult'.$room_type_ids[$i] => 'required',
                'child'.$room_type_ids[$i] => 'required',

            ]);



            $tariff = new Tariff([
                'roomtypeid' => $room_type_ids[$i],
                'fromdate' => $request['from_date'.$room_type_ids[$i]],
                'todate' => $request['to_date'.$room_type_ids[$i]],
                'singleocc' => $request['single'.$room_type_ids[$i]],
                'doubleocc' => $request['double'.$room_type_ids[$i]],
                'extra_adult' => $request['extra_adult'.$room_type_ids[$i]],
                'child' => $request['child'.$room_type_ids[$i]],
                'active' => 'y',
                'user' => auth() -> user() ->name,

            ]);
            $tariff->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function show(Tariff $tariff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function edit(Tariff $tariff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tariff $tariff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tariff  $tariff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tariff $tariff)
    {
        //
    }
}
