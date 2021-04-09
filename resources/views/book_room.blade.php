@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Hobby</div>
                    <div class="card-body">
                        <form action="/roombooked" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{old('first_name')}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"  value="{{old('last_name')}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" class="form-control" id="email" name="email"  value="{{old('email')}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Contact No</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{old('contact_no')}}">>
                            </div>
                            <div class="form-group">
                                <label for="name">Address</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>
                             <div class="form-group">
                                <label for="name">Country</label>
                                <input type="text" class="form-control" id="country" name="country">
                            </div>
                            <div class="form-group">
                                <label for="name">Checkin Date</label>
                                <input type="text" class="form-control" id="checkin" name="checkin">
                            </div>
                            <div class="form-group">
                                <label for="name">Checkout Date</label>
                                <input type="text" class="form-control" id="checkout" name="checkout">
                            </div>
                            <div class="form-group">
                                <label for="name">No of rooms</label>
                                <input type="text" class="form-control" id="no_of_rooms" name="no_of_rooms">
                            </div>
                            <div class="form-group">
                                <label for="name">Room Type</label>
                                <input type="text" class="form-control" id="room_type" name="room_type">
                            </div>
                            <div class="form-group">
                                <label for="name">Adult</label>
                                <input type="text" class="form-control" id="adult" name="adult">
                            </div>
                            <div class="form-group">
                                <label for="name">Child</label>
                                <input type="text" class="form-control" id="child" name="child">
                            </div>
                            <div class="form-group">
                                <label for="name">Payment Method</label>
                                <input type="text" class="form-control" id="payment_method" name="payment_method">
                            </div>

                            
                            <input class="btn btn-primary mt-4" type="submit" value="Book">
                        </form>
                        <a class="btn btn-primary float-right" href="/hobby"><i class="fas fa-arrow-circle-up"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection