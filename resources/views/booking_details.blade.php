@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Booking Details</div>
                    <div class="card-body">
                            @csrf
                            <div class="form-group">
                                <label for="name">First Name</label>
                                {{$transaction->first_name}}
                            </div>
                            <div class="form-group">
                                <label for="name">Last Name</label>
                                {{$transaction->last_name}}
                            </div>
                            <div class="form-group">
                                <label for="name">Email</label>
                                {{$transaction->email}}
                            </div>
                            <div class="form-group">
                                <label for="name">Contact No</label>
                                {{$transaction->contact_no}}
                            </div>
                            <div class="form-group">
                                <label for="name">Address</label>
                                {{$transaction->address}}
                            </div>
                             <div class="form-group">
                                <label for="name">Country</label>
                                {{$transaction->country}}
                            </div>
                            <div class="form-group">
                                <label for="name">Payment Method</label>
                                {{$transaction->payment_method}}
                            </div>                            
                        </form>
                        <a class="btn btn-primary float-right" href="/bookings"><i class="fas fa-arrow-circle-up"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection