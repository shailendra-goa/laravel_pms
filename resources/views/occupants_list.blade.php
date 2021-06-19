@extends('layouts.app')

@section('content')
<div class="container">
<h4 class="mb-3">Occupancy List</h4>
<table class="table table-striped table-hover">
  <thead class="table-dark">
    <tr class="table-active">
      <th scope="col">Room No</th>
      <th scope="col">Guest Names</th>
      <th scope="col">Adult</th>
      <th scope="col">Child</th>
      <th scope="col">Ex. Bed</th>
      <th scope="col">Check In</th>
      <th scope="col">Check Out</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?= $html ?>
  </tbody>
</table>
</div>
@endsection
