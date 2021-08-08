@extends('frontend.layouts.app')
@section('title', 'Magic Pay')
    
@section('content')
   <div class="home">
       <div class="text-center">
            <img src="https://ui-avatars.com/api/?name={{Auth::user()->name}}&background=5842E3&color=fff" class="user_img" alt="{{Auth::user()->name}}">
            <h4 class="my-2">{{Auth::user()->name}}</h4>
            <h5 class="text-muted">{{number_format(Auth::user()->wallet->amount, 2)}}<small> MMK</small></h5>
       </div>

       <div class="row my-4 features">
           <div class="col-6">
               <a href="{{route('scanAndPay')}}">
                    <div class="card shadow">
                        <div class="card-body text-center px-2">
                            <img src="{{asset('frontend/img/scan.png')}}" alt="Scan">
                            <span class="ml-2">Scan & Pay</span>
                        </div>
                    </div>
                </a>
           </div>
           <div class="col-6">
               <a href="{{route('receive-qr')}}">
                   <div class="card shadow">
                       <div class="card-body text-center px-2">
                           <img src="{{asset('frontend/img/qr-code.png')}}" alt="Scan">
                           <span class="ml-2">Receive QR</span>
                       </div>
                   </div>
               </a>
           </div>
       </div>

       <div class="card shadow main__card">
            <div class="card-body pr-0">
                <a href="{{route('transfer')}}">
                    <div class="d-flex justify-content-between">
                        <div>
                            <img src="{{asset('frontend/img/transfer.png')}}" alt="Transfer">
                            <span class="ml-2">Transfer</span>
                        </div>
                        <div class="mt-2">
                            <span class="mr-3"><i class="fas fa-caret-right"></i></span>
                        </div>
                    </div>
                </a>
                <hr>
                <a href="{{route('wallet')}}">
                    <div class="d-flex justify-content-between">
                        <div>
                            <img src="{{asset('frontend/img/wallet.png')}}" alt="Transfer">
                            <span class="ml-2">Wallet</span>
                        </div>
                        <div class="mt-2">
                            <span class="mr-3"><i class="fas fa-caret-right"></i></span>
                        </div>
                    </div>
                </a>
                <hr>
                <a href="{{route('transaction')}}">
                    <div class="d-flex justify-content-between">
                        <div>
                            <img src="{{asset('frontend/img/transaction.png')}}" alt="Transfer">
                            <span class="ml-2">Transaction</span>
                        </div>
                        <div class="mt-2">
                            <span class="mr-3"><i class="fas fa-caret-right"></i></span>
                        </div>
                    </div>
                </a>
            </div>
       </div>
   </div>
@endsection
