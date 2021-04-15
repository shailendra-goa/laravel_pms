@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Hobby</div>
                    <div class="card-body">
                        <form action="/transaction/{{$transaction->transaction_id}}/update" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{$transaction->first_name ?? old('first_name')}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"  value="{{$transaction->last_name ?? old('last_name')}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" class="form-control" id="email" name="email"  value="{{$transaction->email ?? old('email')}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Contact No</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{$transaction->contact_no ?? old('contact_no')}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Address</label>
                                <input type="text" class="form-control" id="address" name="address"  value="{{$transaction->address ?? old('address')}}">
                            </div>
                             <div class="form-group">
                                <label for="name">Country</label>
                                <input type="text" class="form-control" id="country" name="country" value="{{$transaction->country ?? old('country')}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Checkin Date</label>
                                <input type="date" class="form-control" id="checkin" name="checkin" value="{{$booking->from_date ?? old('from_date')}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Checkout Date</label>
                                <input type="date" class="form-control" id="checkout" name="checkout" value="{{$booking->to_date ?? old('to_date')}}">
                            </div>
                            <div class="form-group">
                                <label for="name">No of rooms</label>
                                <input type="text" class="form-control" id="no_of_rooms" name="no_of_rooms" value="{{$booking->no_of_rooms ?? old('no_of_rooms')}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Room Type</label>
                                <input type="text" class="form-control" id="room_type" name="room_type" value="{{$booking->room_type_id ?? old('room_type_id')}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Adult</label>
                                <select class="form-select" aria-label="Default select example" id="adult" name="adult">
                                  <option>Select</option>
                                  <option value="1" <?= $booking->adult == '1' ? ' selected="selected"' : '';?>>1</option>
                                  <option value="2" <?= $booking->adult == '2' ? ' selected="selected"' : '';?>>2</option>
                                  <option value="3" <?= $booking->adult == '3' ? ' selected="selected"' : '';?>>3</option>
                                </select>
                                <label for="name">Child</label>
                                <select class="form-select" aria-label="Default select example" id="child" name="child">
                                  <option selected>Select</option>
                                  <option value="0" <?= $booking->child == '0' ? ' selected="selected"' : '';?>>0</option>
                                  <option value="1" <?= $booking->child == '1' ? ' selected="selected"' : '';?>>1</option>
                                  <option value="2" <?= $booking->child == '2' ? ' selected="selected"' : '';?>>2</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Payment Method</label>
                                <input type="text" class="form-control" id="payment_method" name="payment_method" value="{{$transaction->payment_method ?? old('payment_method')}}">
                            </div>                            
                            <input class="btn btn-primary mt-4" type="submit" value="Save">
                        </form>
                        <a class="btn btn-primary float-right" href="/hobby"><i class="fas fa-arrow-circle-up"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection