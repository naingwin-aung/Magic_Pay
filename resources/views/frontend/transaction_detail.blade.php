@extends('frontend.layouts.app')
@section('title', 'Transaction Detail')
    
@section('content')
    <div class="transaction__detail mb-5">
        <div class="card shadow">
            <div class="card-body">
               <div class="text-center">
                   @if (session('success'))
                    <div class="alert alert-success text-center" role="alert">
                        {{session('success')}}
                    </div>
                   @endif
                    <img src="{{asset('frontend/img/checked.png')}}" alt="Checked" width="55px" class="mb-3">
                    @if ($transaction->type == 1)
                        <h4 class="text-success font-weight-bold">+{{number_format($transaction->amount, 2)}} MMK</h4>
                    @elseif($transaction->type == 2)
                        <h4 class="text-danger font-weight-bold">-{{number_format($transaction->amount, 2)}} MMK</h4>
                    @endif
               </div>
               <hr>
                <div class="d-flex justify-content-between">
                   <span class="text-muted">Trx ID : </span>
                   <span>{{$transaction->trx_id}}</span>
                </div>
               <hr>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Reference No : </span>
                    <span>{{$transaction->ref_no}}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Type : </span>
                    @if ($transaction->type == 1)
                        <span class="badge-pill badge-success">Income</span>
                    @elseif($transaction->type == 2)
                        <span class="badge-pill badge-danger">Expense</span>
                    @endif
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Amount : </span>
                    <span class="{{$transaction->type == 1 ? 'text-success': 'text-danger'}}">{{$transaction->type == 1 ? '+' : '-'}} {{number_format($transaction->amount, 2)}} MMK</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Date & Time : </span>
                    <span>
                        {{$transaction->created_at->toFormattedDateString()}} -
                        {{$transaction->created_at->format('h:i:s A')}}
                    </span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">To Account Name: </span>
                    <span>
                        {{$transaction->source->name}}
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">To phone: </span>
                    <span>
                        {{$transaction->source->phone}}
                    </span>
                </div>
                @if ($transaction->description)
                    <hr>
                    <p class="text-muted mb-1">Description: </p>
                    <p>
                        {{$transaction->description}}
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
