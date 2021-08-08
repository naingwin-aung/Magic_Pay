@extends('frontend.layouts.app')
@section('title', 'Notification Detail')
    
@section('content')
    <div class="notification_detail">
        <div class="card shadow">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{asset('frontend/img/notification.png')}}" alt="Notification" width="220px" height="220px">
                </div>
                <div class="text-center">
                    <h6>{{$notification->data['title']}}</h6>
                    <p class="mb-1">{{$notification->data['message']}}</p>
                </div>
                <div class="text-center mt-3">
                    <a href="{{$notification->data['web_link']}}" class="btn btn-primary">Continue</a>

                    <p class="text-muted mb-1 mt-3">
                        {{$notification->created_at->format('d/m/Y')}}
                        {{$notification->created_at->format('h:i:s A')}}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
