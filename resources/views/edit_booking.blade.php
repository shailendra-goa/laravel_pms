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