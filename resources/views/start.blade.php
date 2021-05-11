@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="container">
              <form action="/availability" method="post">
                @csrf
              <div class="row">
                <div class="col-sm">
                  <label class="form-label">From Date</label>
                </div>
                <div class="col-sm">
                  <input type="date" class="form-control" id="from_date" name="from_date">
                </div>
                 <div class="col-sm">
                  <label class="form-label">To Date</label>
                </div>
                <div class="col-sm">
                  <input type="date" class="form-control" id="to_date" name="to_date">
                </div>
                <div class="col-sm">
                  <button type="submit" class="btn btn-primary mb-3">Check Availability</button>
                </div>
              </div>
            </div>
            </form>
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th scope="col">Date</th>
                  <th scope="col">Room</th>
                  <th scope="col">No of rooms</th>
                  <th scope="col">Booked rooms</th>
                  <th scope="col">Rooms Available</th>
                </tr>
              </thead>
              <tbody>
                <?= $html ?>
             </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
