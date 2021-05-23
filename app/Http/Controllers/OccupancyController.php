<?php

namespace App\Http\Controllers;

use App\Occupancy;
use App\Billing;
use Illuminate\Http\Request;
use DB;

class OccupancyController extends Controller
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
        return view('add_occupancy');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'check_in' => 'required',
            'check_out' => 'required',
            'adult' => 'required',
            'extra_person' => 'required',
            'child' => 'required',
            'guest_name1' => 'required|min:3',
            'email'=> 'email:rfc,dns',
            'contact_no' => 'required',
            'address' => 'required',
            'country' => 'required',
        ]);

        $occupancy = new Occupancy([
            
            'check_in' => $request['check_in'],
            'checkin_time' => $request['checkin_time'],
            'check_out' => $request['check_out'],
            'checkout_time' => $request['checkout_time'],
            'guest_name1' => $request['guest_name1'],
            'guest_name2' => $request['guest_name2'], 
            'email' => $request['email'],
            'contact_no' => $request['contact_no'],
            'address' => $request['address'],
            'country' => $request['country'],
            'user' => auth() -> user() ->name,
        ]);
        //dd($occupancy);
        $occupancy->save();

        $date = $request['check_in'];
        $to_date = $request['check_out'];
        $flagroomAvailable = 1;

        while($date<$to_date)
        {

            $tariffArr = DB::select("select id,singleocc,doubleocc,extra_adult,child from tariffs where fromdate<='".$date."' and todate>='".$date."' and roomtypeid=1");

            if(count($tariffArr)>0)
            {
                foreach ($tariffArr as $tariff)
                {
                    $roomrentsingle = $tariff->singleocc;
                    $roomrentdouble = $tariff->doubleocc;
                    $extrapersonrent = $tariff->extra_adult;
                    $childrent = $tariff->child;
                }

                if($request['adult']==1)
                {
                    $roomrent=$roomrentsingle;
                }
                else
                {
                    $roomrent=$roomrentdouble;
                }

                if($request['extra_person']==0)
                {
                    $extrapersonrent=0;
                }
                else
                {
                    $extrapersonrent=$extrapersonrent*$request['extra_person'];
                }

                if($request['child']==0){
                    $childrent=0;
                }
                else{
                    $childrent=$childrent*$request['child'];
                }

                $amount = $roomrent + $extrapersonrent + $childrent;

                $billing = new Billing([

                    'occupancy_id' => $occupancy->occupancy_id,
                    'day' => $date,
                    'room_no' => $request['room_no'],
                    'adult' => $request['adult'],
                    'extra_person' => $request['extra_person'],
                    'child' => $request['child'],
                    'code' => "TRF",
                    'amount' => $amount,
                    'user' => auth()->user()->name

                ]);

                $billing->save();

            }
            else
            {
                    $roomrentsingle = 0;
                    $roomrentdouble = 0;
                    $extrapersonrent = 0;
                    $childrent = 0;
            }

            $date = date('Y-m-d', strtotime($date. ' + 1 days'));

        }

       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Occupancy  $occupancy
     * @return \Illuminate\Http\Response
     */
    public function show(Occupancy $occupancy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Occupancy  $occupancy
     * @return \Illuminate\Http\Response
     */
    public function edit(Occupancy $occupancy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Occupancy  $occupancy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Occupancy $occupancy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Occupancy  $occupancy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Occupancy $occupancy)
    {
        //
    }
}
