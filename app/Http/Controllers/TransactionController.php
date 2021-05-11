<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Booking;
use App\room_type;
use Illuminate\Http\Request;
use DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        //dd($transactions);

        return view('transactions')->with([
           'transactions' => $transactions 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('book_room');
        $room_types = room_type::all();

        return view('book_room')->with([
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
        //dd('Store function');

        $request->validate([

            //transaction table
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3', 
            'email'=> 'email:rfc,dns',
            'contact_no' => 'required',
            'address' => 'required',
            'country' => 'required',

            //bookings table
            'checkin' => 'required',
            'checkout' => 'required',
            'room_type_id' => 'required',
            //'no_of_rooms' => 'required',
            //'adult' => 'required',
            //'child' => 'required',
        ]);


        $transaction = new Transaction([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'], 
            'email' => $request['email'],
            'contact_no' => $request['contact_no'],
            'address' => $request['address'],
            'country' => $request['country'],
            'payment_method' => $request['payment_method']
        ]);


        $room_type_ids = $request['room_type_id'];
        echo (count($room_type_ids));
        print_r($room_type_ids);

        for($i=0;$i<count($room_type_ids);$i++) 
        {
            echo "no of rooms".$request['no_of_rooms'.$room_type_ids[$i]];
            $flagroomAvailable = $this->Check_Availibilty($request['checkin'],$request['checkout'],$room_type_ids[$i],$request['no_of_rooms'.$room_type_ids[$i]]);
            //echo "Room Available".$flagroomAvailable;
            if(!$flagroomAvailable)
            {
                break;
            }
        }

        if ($flagroomAvailable == 1) 
        {
            $transaction->save();
            for($i=0;$i<count($room_type_ids);$i++) 
            {
                $booking = new Booking([
                    'transaction_id' => $transaction->transaction_id, 
                    'from_date' => $request['checkin'],
                    'to_date' => $request['checkout'],
                    'room_type_id' => $room_type_ids[$i],
                    'no_of_rooms' => $request['no_of_rooms'.$room_type_ids[$i]],
                    'adult' => $request['adult'.$room_type_ids[$i]],
                    'child' => $request['child'.$room_type_ids[$i]],
                    'status' => "confirmed"
                ]);
                $booking->save();

            }

            return $this->booking_list()->with(
                [
                    'message_success' => "Booking of <b>" . $transaction->first_name . " from ". $booking->from_date. " to " .$booking->to_date."</b> is done."
                ]
            );
        }

        else{
            return $this->booking_list()->with(
                [
                    'message_success' => "Booking of <b>" . $transaction->first_name . "</b> could NOT be done."
                ]
            );
        }

        

    }

    public function booking_list()
    {
        $bookings = DB::select("select transactions.transaction_id, first_name, last_name, email, from_date, to_date, room_name, bookings.no_of_rooms, adult, child from transactions inner join bookings on transactions.transaction_id=bookings.transaction_id inner join room_types on bookings.room_type_id=room_types.room_type_id order by transactions.created_at desc");

        return view('transactions')->with([
           'bookings' => $bookings 
        ]);


    }


    public function Check_Availibilty($from_date,$to_date,$room_type_id,$booking_rooms)
    {

        $date = $from_date;
        $flagroomAvailable = 1;
        while(($date<$to_date) && ($flagroomAvailable == 1))
        {

            DB::enableQueryLog();
            $bookedArr = DB::select("select room_types.no_of_rooms, sum(bookings.no_of_rooms) as rooms_booked from bookings inner join room_types on room_types.room_type_id=bookings.room_type_id where bookings.room_type_id=".$room_type_id." and from_date<='".$date."' and to_date>'".$date."' group by room_types.no_of_rooms");
            $query = DB::getQueryLog();
            $query = end($query);

            if(count($bookedArr)>0)
            {
                foreach ($bookedArr as $booked)
                {
                  $rooms_available = $booked->no_of_rooms - $booked->rooms_booked;
                  if($rooms_available > $booking_rooms){
                    $flagroomAvailable = 1;
                  }
                  else{
                    $flagroomAvailable = 0;
                  }
                }

            }
            else
            {
                $flagroomAvailable = 1;
            }
            
            $date = date('Y-m-d', strtotime($date. ' + 1 days'));

        } 


        //print_r($flagroomAvailable);
        //exit();
        return $flagroomAvailable;
    }

    public function show_availability(Request $request)
    {
        $from_date = isset($request['from_date']) ? $request['from_date'] : date('Y-m-d');
        $date = $from_date;
        $to_date = isset($request['to_date'])  ? $request['to_date'] : (date('Y-m-d', strtotime($from_date. ' + 10 days')));

        $html = '';    

        while(($date<$to_date))
        {
            $roomArr = DB::table('room_types')->select('room_type_id', 'room_name','no_of_rooms')->get()->toArray();

            //echo "<pre>";print_r($roomArr);

            foreach ($roomArr as $room)
            {

                //print_r($room -> room_type_id);
                //print_r($room -> room_name);

                DB::enableQueryLog();
                $bookedArr = DB::select("select sum(no_of_rooms) as booked_rooms from bookings where room_type_id=".$room -> room_type_id." and from_date<='".$date."' and to_date>'".$date."'");
                $query = DB::getQueryLog();
                $query = end($query);
                foreach ($bookedArr as $booked)
                {
                  $html .= '<tr>
                      <th scope="row">'.$date.'</th>
                      <td>'.$room -> room_name.'</td>
                      <td>'.$room -> no_of_rooms.'</td>
                      <td>'.(empty($booked -> booked_rooms) ? '0' : $booked -> booked_rooms) .'</td>
                      <td>'.($room -> no_of_rooms - (empty($booked -> booked_rooms) ? '0' : $booked -> booked_rooms)) .'</td>
                    </tr>';
                }


            }

            $date = date('Y-m-d', strtotime($date. ' + 1 days'));

        } 

        //echo "<pre>";print_r($html);

        //exit();


        return view('start')->with([
           'html' => $html 
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction, Booking $booking)
    {
        $booking_details = DB::table('bookings')->where('transaction_id', $transaction->transaction_id)->get();

        foreach ($booking_details as $key => $value) {
                $booking->from_date = $value->from_date;
                $booking->to_date = $value->to_date;
                $booking->no_of_rooms = $value->no_of_rooms;
                $booking->room_type_id = $value->room_type_id;
                $booking->adult = $value->adult;
                $booking->child = $value->child;
        }

        return view('booking_details')->with([

            'transaction' => $transaction, 'booking' => $booking

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction, Booking $booking)
    {
        echo $transaction->transaction_id;
        DB::enableQueryLog();
        //$booking = \App\Booking::find($transaction->transaction_id);
        $booking_details = DB::table('bookings')->where('transaction_id', $transaction->transaction_id)->get();
        //dd(DB::getQueryLog());

        //echo "<pre>";print_r($booking);exit();

        /*$booking_details=DB::select("select booking_id,from_date,to_date,room_type_id,no_of_rooms,adult,child from bookings where transaction_id =".$transaction->transaction_id);*/
        //echo "<pre>";print_r($booking_details);exit();


        /*foreach ($booking_details as $key => $value) {
                $booking->from_date = $value->from_date;
                $booking->to_date = $value->to_date;
                $booking->no_of_rooms = $value->no_of_rooms;
                $booking->room_type_id = $value->room_type_id;
                $booking->adult = $value->adult;
                $booking->child = $value->child;
        }*/

        //echo "<pre>";print_r($booking);exit();

        $room_types = room_type::all();

        return view('edit_booking')->with([

            'transaction' => $transaction, 'bookings' => $booking_details, 'room_types' => $room_types

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {

        $request->validate([

            //transaction table
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3', 
            'email'=> 'email:rfc,dns',
            'contact_no' => 'required',
            'address' => 'required',
            'country' => 'required',

            //bookings table
            'checkin' => 'required',
            'checkout' => 'required',
            //'room_type_id' => 'required',
            //'no_of_rooms' => 'required',
            //'adult' => 'required',
            //'child' => 'required',
        ]);

        $room_type_ids = $request['room_type_id'];

        for($i=0;$i<count($room_type_ids);$i++) 
        {
            $flagroomAvailable = $this->Check_Availibilty($request['checkin'],$request['checkout'],$room_type_ids[$i],$request['no_of_rooms'.$room_type_ids[$i]]);
            //echo "Room Id ".$room_type_ids[$i];
            //echo "Room Available ".$flagroomAvailable;
            if(!$flagroomAvailable)
            {
                break;
            }

        }

        if($flagroomAvailable)
        {
            $transaction->update([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'], 
                'email' => $request['email'],
                'contact_no' => $request['contact_no'],
                'address' => $request['address'],
                'country' => $request['country'],
                'payment_method' => $request['payment_method']
            ]);

            $deletedRows = Booking::where('transaction_id', $transaction->transaction_id)->delete();
            print_r($deletedRows);

            for($i=0;$i<count($room_type_ids);$i++) 
            {
                $booking = new Booking([
                    'transaction_id' => $transaction->transaction_id, 
                    'from_date' => $request['checkin'],
                    'to_date' => $request['checkout'],
                    'room_type_id' => $room_type_ids[$i],
                    'no_of_rooms' => $request['no_of_rooms'.$room_type_ids[$i]],
                    'adult' => $request['adult'.$room_type_ids[$i]],
                    'child' => $request['child'.$room_type_ids[$i]],
                    'status' => "confirmed"
                ]);
                $booking->save();

            }



            return $this->booking_list()->with(
                [
                    'message_success' => "Booking of <b>" . $transaction->first_name . "</b> is updated."
                ]
            );
        }
        else
        {
            return $this->booking_list()->with(
                [
                    'message_success' => "Rooms NOT available."
                ]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $oldName = $transaction->first_name;
        $transaction->delete();
        Booking::where('transaction_id', $transaction->transaction_id)->delete();
        return $this->booking_list()->with(
            [
                'message_success' => "Booking of <b>" . $oldName . "</b> is deleted. Rooms not available."
            ]
        );
    }
}
