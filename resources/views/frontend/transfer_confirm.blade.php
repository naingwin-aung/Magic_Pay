@extends('frontend.layouts.app')
@section('title', 'Transfer Confirmation')
    
@section('content')
    <div class="transfer_confirm mb-5">
        <div class="card shadow">
            <div class="card-body"> 
                <h4 class="text-center">Check Your Transfer</h4>
                <hr>

                @include('frontend.layouts.flash')

                <h5 class="mt-4">From - <span class="text-uppercase">{{$from_account->name}}</span></h5>
                <p class="text-muted">{{$from_account->phone}}</p>

                <form action="{{route('transfer_complete')}}" method="POST" id="confirm-form">
                    @csrf
                    <input type="hidden" value="{{$to_account->phone}}" name="to_phone">
                    <input type="hidden" value="{{$amount}}" name="amount">
                    <input type="hidden" value="{{$description}}" name="description">
                    <input type="hidden" name="hash_value" value="{{$hash_value}}">

                    <div class="form-group mb-3">
                        <label for="to" class="mb-0">To</label>
                        <p class="mb-1 text-muted">{{$to_account->name}}</p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="to" class="mb-0">Phone Number</label>
                        <p class="mb-1 text-muted">{{$to_account->phone}}</p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="to" class="mb-0">Amount (MMK)</label>
                        <p class="mb-1 text-muted">{{$amount}}</p>
                    </div>

                    @if ($description)
                        <div class="form-group mb-3">
                            <label for="to" class="mb-0">Description</label>
                            <p class="mb-1 text-muted">{{$description}}</p>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary float-right mt-3 confirm-btn">Confirm</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.confirm-btn').on('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Please fill your password',
                    icon: 'info',
                    html:'<input type="password" class="form-control password text-center">',
                    showCloseButton: true,
                    showCancelButton: true,
                    reverseButtons : true,
                    confirmButtonText:
                        'Confirm',
                    cancelButtonText:
                        'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        let password = $('.password').val();
                        $.ajax({
                            url : `/password-check?password=${password}`,
                            type : 'GET',
                            success : function(res) {
                                if(res.status == 'success') {
                                    $('#confirm-form').submit();
                                }
                                if(res.status == 'fail') {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: res.message,
                                    })
                                }
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection