@extends('frontend.layouts.app')
@section('title', 'Wallet')
    
@section('content')
    <div class="wallet">
        <div class="card shadow bg-primary text-white">
            <div class="card-body">
                <h4 class="mb-2 font-weight-bold">BALANCE</h4>
                <h3 class="mb-4 font-weight-bold">{{number_format($user->wallet->amount, 2)}} <span>MMK</span></h3>
    
                <h4 class="mb-2 font-weight-bold">ACCOUNT NUMBER</h4>
                <h5 class="mb-4 font-weight-bold">{{$user->wallet->account_number}}</h5>
                <h5>{{$user->name}}</h5>
            </div>
        </div>
    </div>
@endsection
