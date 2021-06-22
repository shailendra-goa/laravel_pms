<?php

namespace App\Http\Controllers;

use App\Occupancy;
use App\Billing;
use App\Room;
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
            'check_in' => date('Y-m-d',strtotime($request['check_in'])),
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
        $occupancy->save();

        $date = date('Y-m-d',strtotime($request['check_in']));
        $to_date = $request['check_out'];
        $flagroomAvailable = 1;

        $rooms = Room::where('room_no',$request['room_no'])->first();

        while($date<$to_date)
        {

            $tariffArr = DB::select("select id,singleocc,doubleocc,extra_adult,child from tariffs where fromdate<='".$date."' and todate>='".$date."' and roomtypeid=".$rooms->room_type_id);

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

        return $this->occupant_list();

       
    }

    public function occupant_list()
    {
        DB::enableQueryLog();
        $rooms = DB::table('rooms')->where('active', 'y')->get();
        //dd(DB::getQueryLog());
        $html = ''; 
        foreach($rooms as $room) {
            $occupancy = DB::select("select occupancies.occupancy_id,billings.id,guest_name1,guest_name2,adult,extra_person,child,check_in,check_out from occupancies inner join billings on billings.occupancy_id=occupancies.occupancy_id where day='".date('Y-m-d')."' and room_no=".$room->room_no);
            if($occupancy) {
                foreach ($occupancy as $occupant) {
                    $html .= '<tr>
                              <th scope="row">'.$room->room_no.'</th>
                              <td>'.$occupant->guest_name1. '/' .$occupant->guest_name2.'</td>
                              <td>'.$occupant->adult.'</td>
                              <td>'.$occupant->extra_person.'</td>
                              <td>'.$occupant->child.'</td>
                              <td>'.date("d-m-Y", strtotime($occupant->check_in)).'</td>
                              <td>'.date("d-m-Y", strtotime($occupant->check_out)).'</td>
                              <td>
                              <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                  Select Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                  <li><a class="dropdown-item" href="occupancy/'.$occupant->occupancy_id.'/edit">Edit Guest details</a></li>
                                  <li><a class="dropdown-item" href="occupancy/'.$occupant->occupancy_id.'/roompax">Change Room/Pax</a></li>
                                  <li><a class="dropdown-item" href="#">Change Dates</a></li>
                                  <li><a class="dropdown-item" href="#">Change Tariff</a></li>
                                </ul>
                              </div>
                          </td>
                          </tr>';
                }
                
            }
            else {
                    $html .= '<tr>
                              <th scope="row">'.$room->room_no.'</th>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td>&nbsp</td>
                              <td><a class="btn btn-sm btn-outline-primary" href="/occupancy-add?room_no='.$room->room_no.'">Add</a></td>
                          </tr>';                
            }

        }
        return view('occupants_list')->with([
            'html' => $html
        ]);
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
      //DB::enableQueryLog();
      //$occupancy_details = DB::table('occupancies')->where('occupancy_id', $occupancy->occupancy_id)->first();
      $occupancy_details = Occupancy::find($occupancy->occupancy_id);
      //dd(DB::getQueryLog());


      return view('edit_occupancy')->with([
        'occupancy' => $occupancy_details
      ]);
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
        $request->validate([
            'guest_name1' => 'required|min:3',
            'email'=> 'email:rfc,dns',
            'contact_no' => 'required',
            'address' => 'required',
            'country' => 'required',
        ]);

        $occupancy->update([
              'guest_name1' => $request['guest_name1'],
              'guest_name2' => $request['guest_name2'], 
              'email' => $request['email'],
              'contact_no' => $request['contact_no'],
              'address' => $request['address'],
              'country' => $request['country'],
              'user' => auth() -> user() ->name,
        ]);

        return $this->occupant_list()->with(
          [
              'message_success' => "Occupancy details <b>" . $occupancy->guest_name1 ."</b> is changed."
          ]
        );

    }

    public function viewroompax(Occupancy $occupancy, Billing $billing){
      $occupancy_details = Occupancy::find($occupancy->occupancy_id);
      $billing_details = Billing::where('occupancy_id', $occupancy->occupancy_id)->get();
      return view('changeroom')->with([
        'occupancy' => $occupancy_details,
        'billings' => $billing_details
         ]);
    }

    //Function to change room and/or occupancy ie no. of adults, children and extra person. Accordingly tariff is changed
    public function changeroom(Request $request, Billing $billing) {
      $billing_ids = $request['id'];
      DB::enableQueryLog();
      for($i=0; $i<count($billing_ids);$i++) {
        

        $rooms = Room::where('room_no',$request['room_no'.$billing_ids[$i]])->first();
        //dd(DB::getQueryLog());

        $tariffArr = DB::select("select id,singleocc,doubleocc,extra_adult,child from tariffs where fromdate<='".$request['day'.$billing_ids[$i]]."' and todate>='".$request['day'.$billing_ids[$i]]."' and roomtypeid=".$rooms->room_type_id);

        if(count($tariffArr)>0)
        {
            foreach ($tariffArr as $tariff)
            {
                $roomrentsingle = $tariff->singleocc;
                $roomrentdouble = $tariff->doubleocc;
                $extrapersonrent = $tariff->extra_adult;
                $childrent = $tariff->child;
            }

            if($request['adult'.$billing_ids[$i]]==1)
            {
                $roomrent=$roomrentsingle;
            }
            else
            {
                $roomrent=$roomrentdouble;
            }

            if($request['extra_person'.$billing_ids[$i]]==0)
            {
                $extrapersonrent=0;
            }
            else
            {
                $extrapersonrent=$extrapersonrent*$request['extra_person'.$billing_ids[$i]];
            }

            if($request['child'.$billing_ids[$i]]==0){
                $childrent=0;
            }
            else{
                $childrent=$childrent*$request['child'.$billing_ids[$i]];
            }

            $amount = $roomrent + $extrapersonrent + $childrent;
        }
        else
        {
            $roomrentsingle = 0;
            $roomrentdouble = 0;
            $extrapersonrent = 0;
            $childrent = 0;
        }
        
        //Below ORM not working
        /*$billing->update([
            'room_no' => $request['room_no'.$billing_ids[$i]],
            'adult' => $request['adult'.$billing_ids[$i]],
            'extra_person' => $request['extra_person'.$billing_ids[$i]],
            'child' => $request['child'.$billing_ids[$i]]
        ]);*/

        DB::table('billings')
            ->where('id', $billing_ids[$i])
            ->update([
              'room_no' => $request['room_no'.$billing_ids[$i]],
              'adult' => $request['adult'.$billing_ids[$i]],
              'extra_person' => $request['extra_person'.$billing_ids[$i]],
              'child' => $request['child'.$billing_ids[$i]],
              'amount' => $amount,
              'user' => auth()->user()->name
          ]);
        
      }

     return $this->occupant_list()->with(
          [
              'message_success' => "Room/Occupancy details is changed."
          ]
      );
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

