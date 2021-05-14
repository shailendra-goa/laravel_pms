@extends('layouts.app')

@section('content')
<div class="container">
<h4 class="mb-3">Search booking</h4>
<form name="search_booking_form" action="/search" method="post">
  @csrf
  <div class="row form-group">
    <div class="col">
      <input type="radio" name="search" value="transaction_id_opt"> Transaction Id <input type="text" class="form-control" id="transaction_id" name="transaction_id" onFocus="rbtrans_id()">
    </div>
    <div class="col">
      <input type="radio" name="search" value="name_opt"> Name <input type="text" class="form-control" id="name" name="name" onfocus="rbname()">
    </div>
    <div class="col">
      <input type="radio" name="search" value="checkin_opt"> Check in date <input type="date" class="form-control" id="checkin" name="checkin" onfocus="rbcheckin()">
    </div>  
  </div>
  <div class="row form-group">
      <div class="col text-center"><button type="submit" class="btn btn-primary">Search</button></div>
  </div>
</form>
<hr>
</div>
<div class="container">
<table class="table table-hover">
  <thead>
    <tr class="table-active">
      <th scope="col">#</th>
      <th scope="col">Guest Name</th>
      <th scope="col">From Date</th>
      <th scope="col">To Date</th>
      <th scope="col">No. of rooms</th>
      <th scope="col">Room type</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  @if($bookings)
    @foreach($bookings as $booking)
    <tr>
      <th scope="row">{{ $booking->transaction_id}}</th>
      <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
      <td>{{ $booking->from_date }}</td>
      <td>{{ $booking->to_date }}</td>
      <td>{{ $booking->no_of_rooms }}</td>
      <td>{{ $booking->room_name }}</td>
      <td>
        <a class="btn btn-sm btn-outline-primary" href="/transaction/{{ $booking->transaction_id }}/edit">Edit</a>
        <form class="" style="display: inline" action="/transaction/{{$booking->transaction_id}}/destroy" method="post">
        @csrf
        @method("DELETE")
        <input class="btn btn-sm btn-outline-danger" type="submit" value="Delete">
        </form>
      </td>
    </tr>
    @endforeach
  @else
  <tr>
      <th colspan="7" class="alert alert-danger text-center">No records for {{$search_value}}</th>

    </tr>
  @endif

  </tbody>
</table>
</div>
@endsection

<script type="text/javascript">
function rbtrans_id()
{
  var j=0;
  document.search_booking_form.search[j].checked=true;

}

function rbname()
{
  var j=1;
  document.search_booking_form.search[j].checked=true;

}

function rbcheckin()
{
  var j=2;
  document.search_booking_form.search[j].checked=true;

}
</script>