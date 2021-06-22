<?php
namespace App\Http\Controllers;
use App\Http\Controllers\OccupancyController;

?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Occupancy</div>
                    <div class="card-body">
                        <form action="/occupancy/{{$occupancy->occupancy_id}}/update" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group form-row">
                              <div class="col">
                               <label for="name">Guest Name1</label>
                                <input type="text" class="form-control" id="guest_name1" name="guest_name1" value="{{ $occupancy->guest_name1 ?? old('guest_name1') }}">
                              </div>
                              <div class="col">
                                <label for="name">Guest Name2</label>
                                <input type="text" class="form-control" id="guest_name2" name="guest_name2"  value="{{ $occupancy->guest_name2 ?? old('guest_name2')}}">
                              </div>
                            </div>
                            <div class="form-group form-row">
                              <div class="col">
                                <label for="name">Email</label>
                                <input type="text" class="form-control" id="email" name="email"  value="{{ $occupancy->email ?? old('email')}}">
                              </div>
                              <div class="col">
                                <label for="name">Contact No</label>
                                <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ $occupancy->contact_no ?? old('contact_no')}}">
                              </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ $occupancy->address ?? old('address')}}">
                            </div>
                             <div class="form-group">
                                <label for="name">Country</label>
                                <input type="text" class="form-control" id="country" name="country" value="{{$occupancy->country ?? old('country')}}">
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