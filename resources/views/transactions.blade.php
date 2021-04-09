@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Bookings</div>

                <div class="card-body">
                    @foreach($transactions as $transaction)
                        <li>
                            <a href="/transaction/{{ $transaction->transaction_id }}">{{ $transaction->first_name }} {{ $transaction->last_name }} </a>
                            <a class="btn btn-sm btn-light ml-2" href="/transaction/{{ $transaction->transaction_id }}/edit"><i class="fas fa-edit"></i>Edit</a>
                            <form class="float-right" style="display: inline" action="/transaction/{{$transaction->transaction_id}}/destroy" method="post">
                            @csrf
                            @method("DELETE")
                            <input class="btn btn-sm btn-outline-danger" type="submit" value="Delete">
                            </form>
                        </li> <br> 

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection