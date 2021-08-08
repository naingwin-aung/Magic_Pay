@extends('frontend.layouts.app')
@section('title', 'Receive QR')
    
@section('content')
    <div class="receiveqr">
        <div class="card shadow">
            <div class="card-body text-center">
               <h5>QR Scan to Pay me</h5>
               <div class="my-5">
                   {!! QrCode::size(170)->color(88, 66, 227)->generate($user->phone); !!}
                   {{-- {!! QrCode::size(180)->phoneNumber($user->phone) !!} --}}
               </div>
               <h4 class="mb-3">{{$user->name}}</h4>
               <h6 class="text-muted">{{$user->phone}}</h6>
            </div>
        </div>
    </div>
@endsection
