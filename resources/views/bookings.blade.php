@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Info</div>

                <div class="card-body">
                    @foreach($bookings as $booking)
                    <li>
                        {{ $booking->booking_id }}
                    </li>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection