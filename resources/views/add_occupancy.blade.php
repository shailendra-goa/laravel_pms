@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Occupancy</div>
                    <div class="card-body">
                        <form action="/occupancy_added" method="post">
                            @csrf
                            <div class="form-group form-row">
                              <div class="col">
                                <label for="name">Room no</label>
                                <input type="text" class="form-control" id="room_no" name="room_no">
                              </div>
                              <div class="col">
                                <label for="name">Checkin Date</label>
                                <input type="date" class="form-control" id="check_in" name="check_in" value="{{old('check_in')}}">
                              </div>
                              <div class="col">
                                <label for="name">Checkin Time</label>
                                <input type="time" class="form-control" id="checkin_time" name="checkin_time" value="{{old('checkin_time')}}">
                              </div>
                            </div>
                            <div class="form-group form-row">
                              <div class="col">
                                <label for="name">Checkout Date</label>
                                <input type="date" class="form-control" id="check_out" name="check_out" value="{{old('checkin_out')}}">
                              </div>
                              <div class="col">
                                <label for="name">Checkout Time</label>
                                <input type="time" class="form-control" id="checkout_time" name="checkout_time" value="{{old('checkout_time')}}">
                              </div>
                            </div>
                            <div class="form-group form-row">
                              <div class="col">
                                <label for="name">Adult</label>
                                <input type="text" class="form-control" id="adult" name="adult" value="{{old('adult')}}">
                              </div>
                              <div class="col">
                                <label for="name">Extra Person</label>
                                <input type="text" class="form-control" id="extra_person" name="extra_person" value="{{old('extra_person')}}">
                              </div>
                              <div class="col">
                                <label for="name">Child</label>
                                <input type="text" class="form-control" id="child" name="child" value="{{old('child')}}">
                              </div>
                            </div>
                            <div class="form-group form-row">
                              <div class="col">
                               <label for="name">Guest Name1</label>
                                <input type="text" class="form-control" id="guest_name1" name="guest_name1" value="{{old('guest_name1')}}">
                              </div>
                              <div class="col">
                                <label for="name">Guest Name2</label>
                                <input type="text" class="form-control" id="guest_name2" name="guest_name2"  value="{{old('guest_name2')}}">
                              </div>
                            </div>
                            <div class="form-group form-row">
                              <div class="col">
                                <label for="name">Email</label>
                                <input type="text" class="form-control" id="email" name="email"  value="{{old('email')}}">
                              </div>
                              <div class="col">
                                <label for="name">Contact No</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{old('contact_no')}}">
                              </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}">
                            </div>
                             <div class="form-group">
                                <label for="name">Country</label>
                                <input type="text" class="form-control" id="country" name="country" value="{{old('country')}}">
                            </div>
                            <div class="text-center">
                                <input class="btn btn-primary mt-4" type="submit" value="Save">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection