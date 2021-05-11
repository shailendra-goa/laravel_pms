@extends('layouts.app')

@section('content')
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
        <form class="float-center" style="display: inline" action="/transaction/{{$booking->transaction_id}}/destroy" method="post">
        @csrf
        @method("DELETE")
        <input class="btn btn-sm btn-outline-danger" type="submit" value="Delete">
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
@endsection