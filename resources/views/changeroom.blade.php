<?php
namespace App\Http\Controllers;
use App\Http\Controllers\OccupancyController;

?>
@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row ">
		<div class="col-md-12">
            <div class="card">
                <div class="card-header">Change Room</div>
                    <div class="card-body">
                	   <div class="row">
                            <div class="col-4">Guest names: {{ $occupancy->guest_name1 }} / {{ $occupancy->guest_name2 }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Check in: {{ $occupancy->check_in }}</div>
                        </div>
                        <div class="row">
                            <div class="col-4">Check out: {{ $occupancy->check_out }}</div>
                        </div>
                        <div class="row">
                            <form action="/occupancy/{{ $occupancy->occupancy_id }}/changeroom" method="post">
                                @csrf
                                @method('PUT')
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th scope="col">Date</th>
                                      <th scope="col">Room no.</th>
                                      <th scope="col">Adult</th>
                                      <th scope="col">Extra Person</th>
                                      <th scope="col">Child</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($billings as $billing)
                                    <tr>
                                      <input type="hidden" name="id[]" value="{{ $billing->id }}">
                                      <input type="hidden" name="occupancy_id" value="{{ $billing -> occupancy_id }}">
                                      <input type="hidden" name="day{{ $billing -> id }}" value="{{ $billing->day }}">
                                      <th scope="row">{{ $billing -> day }}</th>
                                      <td scope="row"><input type="text" name="room_no{{ $billing -> id }}" value="{{ $billing -> room_no }}" class="input-sm"></td>
                                      <td><input type="number" name="adult{{ $billing->id }}" value="{{ $billing -> adult }}"></td>
                                      <td><input type="number" name="extra_person{{ $billing -> id }}" value="{{ $billing -> extra_person }}"></td>
                                      <td><input type="number" name="child{{ $billing -> id }}" value="{{ $billing -> child }}"></td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                                <div class="text-center">
                                    <input class="btn btn-primary mt-4" type="submit" value="Book">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection