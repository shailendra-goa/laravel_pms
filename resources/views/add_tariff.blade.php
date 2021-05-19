@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header">Add Tariff</div>
              <div class="card-body">
                <form name="add_tariff_form" action="/tariff_add" method="post">
                  @csrf
                  <div class="row form-group">
                    <div class="col font-weight-bold">
                      Room Type
                    </div>
                    <div class="col col-lg-2 font-weight-bold">
                      From Date
                    </div>
                    <div class="col col-lg-2 font-weight-bold">
                      To date
                    </div>  
                    <div class="col font-weight-bold">
                      Single
                    </div>  
                    <div class="col font-weight-bold">
                      Double
                    </div> 
                    <div class="col font-weight-bold">
                      Extra Adult
                    </div> 
                    <div class="col font-weight-bold">
                      Child
                    </div> 
                  </div>
                  @foreach($room_types as $room_type)
                  <div class="row form-group">
                    <div class="col">
                      <input type="checkbox" name="room_type_id[]" value="{{ $room_type->room_type_id }}"> {{$room_type->room_name}}
                    </div>
                    <div class="col col-lg-2">
                      <input type="date" class="form-control" id="from_date{{ $room_type->room_type_id }}" name="from_date{{ $room_type->room_type_id }}">
                    </div>
                    <div class="col col-lg-2">
                      <input type="date" class="form-control" id="to_date" name="to_date{{ $room_type->room_type_id }}">
                    </div>  
                    <div class="col">
                      <input type="text" class="form-control" id="single" name="single{{ $room_type->room_type_id }}">
                    </div>  
                    <div class="col">
                      <input type="text" class="form-control" id="double" name="double{{ $room_type->room_type_id }}">
                    </div> 
                    <div class="col">
                      <input type="text" class="form-control" id="extra_adult" name="extra_adult{{ $room_type->room_type_id }}">
                    </div> 
                    <div class="col">
                      <input type="text" class="form-control" id="child" name="child{{ $room_type->room_type_id }}">
                    </div> 
                  </div>
                  @endforeach
                  <div class="row form-group">
                      <div class="col text-center"><button type="submit" class="btn btn-primary">Add</button></div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
</div>
@endsection