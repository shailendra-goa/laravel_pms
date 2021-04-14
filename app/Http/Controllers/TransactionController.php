<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Booking;
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
        return view('book_room');
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
            'room_type' => 'required',
            'no_of_rooms' => 'required',
            'adult' => 'required',
            'child' => 'required',
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

        $flagroomAvailable = $this->Check_Availibilty($request['checkin'],$request['checkout'],$request['room_type'],$request['no_of_rooms']);
        if ($flagroomAvailable == 1) {
            $transaction->save();
            $booking = new Booking([
                'transaction_id' => $transaction->transaction_id, 
                'from_date' => $request['checkin'],
                'to_date' => $request['checkout'],
                'room_type_id' => $request['room_type'],
                'no_of_rooms' => $request['no_of_rooms'],
                'adult' => $request['adult'],
                'child' => $request['child'],
                'status' => 'confirmed'
            ]);

            $booking->save();

            return $this->index()->with(
                [
                    'message_success' => "Booking of <b>" . $transaction->first_name . "</b> is done."
                ]
            );
        }
        else{
            return $this->index()->with(
                [
                    'message_success' => "Booking of <b>" . $transaction->first_name . "</b> could NOT be done."
                ]
            );
        }

        

    }


    public function Check_Availibilty($from_date,$to_date,$room_type_id,$booking_rooms)
    {

        //DB::enableQueryLog();
        $bookings = DB::select("select date,room_name,room_inventories.no_of_rooms as total_rooms_assigned,sum(bookings.no_of_rooms) as rooms_booked 
        from room_inventories
        join room_types on room_types.room_type_id=room_inventories.room_type_id and date between '".$from_date."' and '".$to_date."' and room_inventories.room_type_id=".$room_type_id."
        left join bookings on bookings.room_type_id=room_inventories.room_type_id and (from_date<=date and to_date>date) 
        group by date,room_inventories.room_type_id,room_name,room_inventories.no_of_rooms order by date asc, room_inventories.room_type_id");
        //$query = DB::getQueryLog();
        //$query = end($query);
        //echo "<pre>";print_r($query); 
        foreach($bookings as $booking){
            $rooms_available = $booking->total_rooms_assigned - $booking->rooms_booked;
            if($rooms_available > $booking_rooms){
                $flagroomAvailable = 1;
            }
            else{
                $flagroomAvailable = 0;
            }
        } 
        //print_r($flagroomAvailable);
        return $rooms_available;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return view('booking_details')->with([

            'transaction' => $transaction

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        return view('edit_booking')->with([

            'transaction' => $transaction

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

            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3', 
            'email'=> 'email:rfc,dns',
            'contact_no' => 'required',
            'address' => 'required',
            'country' => 'required',
        ]);

        $transaction->update([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'], 
            'email' => $request['email'],
            'contact_no' => $request['contact_no'],
            'address' => $request['address'],
            'country' => $request['country'],
            'payment_method' => $request['payment_method']
        ]);

        return $this->index()->with(
            [
                'message_success' => "Booking of <b>" . $transaction->first_name . "</b> is updated."
            ]
        );
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
        return $this->index()->with(
            [
                'message_success' => "Booking of <b>" . $oldName . "</b> is deleted."
            ]
        );
    }
}
