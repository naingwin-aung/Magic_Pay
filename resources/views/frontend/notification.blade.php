@extends('frontend.layouts.app')
@section('title', 'Notification')
    
@section('content')
    @if ($notifications->count())
        <div class="notification mb-5">
            <h6 class="ml-2 font-weight-bold">Notifications</h6>
            <div class="infinite-scroll">
                @foreach ($notifications as $notification)
                    <a href="{{route('notification.detail', $notification->id)}}">
                        <div class="card shadow mb-2">
                            <div class="card-body py-3">
                                <div class="d-flex justify-content-between">
                                    <h6>{{Illuminate\Support\Str::limit($notification->data['title'], 20)}}</h6>
                                    
                                    @if (is_null($notification->read_at))
                                        <i class="fas fa-envelope text-danger" title="Mark as read"></i>
                                    @endif
                                </div>
                                <p class="mb-1">{{Illuminate\Support\Str::limit($notification->data['message'], 100)}}</p>
                                
                                <small class="text-muted">
                                    {{$notification->created_at->diffForHumans()}} - 
                                    {{$notification->created_at->toFormattedDateString()}} - 
                                    {{$notification->created_at->format('h:i:s A')}}
                                </small>
                            </div>
                        </div>
                    </a>
                @endforeach
                <div class="d-none">
                    {{$notifications->links()}}
                </div>
            </div>
        </div>
    @else
        <h5 class="text-muted text-center">No Notifications</h5>
    @endif
@endsection
@section('script')
    <script>
        $('ul.pagination').hide();
        $(function() {
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="text-primary">Loading......</div>',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            })
        })
    </script>
@endsection
