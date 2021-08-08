@extends('frontend.layouts.app')
@section('title', 'Transfer')
    
@section('content')
    <div class="transfer">
        <div class="card shadow">
            <div class="card-body"> 
                <h5>From - <span class="text-uppercase">{{$user->name}}</span></h5>
                <p class="text-muted">{{$user->phone}}</p>
                <hr>

                @include('frontend.layouts.flash')

                @if (session('security'))
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        {{session('security')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form action="{{route('transfer.confirmform')}}" method="GET" id="transfer" autocomplete="off">
                    <input type="hidden" name="hash_value" class="hash_value" value="">
                    <div class="form-group">
                        <label for="to">To <span class="to-account-fail text-danger"></span><span class="to-account-success text-success"></span></label>
                        <div class="input-group">
                            <input type="number" class="form-control to_phone" placeholder="Enter Transfer Phone Number" name="to_phone" 
                            value="{{old("to_phone")}}">
                            <div class="input-group-append">
                              <button class="btn btn-primary to_verify" type="button"><i class="fas fa-check-circle"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount (MMK)</label>
                        <input type="text" class="form-control amount" placeholder="Enter Amount (MMK)" name="amount" value="{{old('amount')}}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control description" placeholder="Type a message...">{{old('description')}}</textarea>
                    </div>
                    <button class="btn btn-primary float-right mt-3 submit-btn">Continue</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\TransferFormRequest', '#transfer') !!}
    <script>
        $(document).ready(function() {
            $('.to_verify').on('click', function() {
                let to_phone = $('.to_phone').val();
                $.ajax({
                    url : `/to-verify-account?to_phone=${to_phone}`,
                    type : 'GET',
                    success : function(res) {
                        if(res.status == 'success') {
                            $('.to-account-fail').text('');
                            $('.to-account-success').text('('+res.data.name+')')
                        }
                        if(res.status == 'fail') {
                            $('.to-account-success').text('');
                            $('.to-account-fail').text('('+res.message+')');
                            $('.to_phone').addClass('is-invalid');
                        }
                    }   
                })
            })

            $('.submit-btn').on('click', function() {
                let to_phone = $('.to_phone').val();
                let amount = $('.amount').val();
                let description = $('.description').val();

                $.ajax({
                    url : `/transfer-hash?to_phone=${to_phone}&amount=${amount}&description=${description}`,
                    type: 'GET',
                    success : function(res){
                        if(res.status == 'success') {
                            $('.hash_value').val(res.data);
                            $('#transfer').submit();
                        }
                    }
                })
            })
        })
    </script>
@endsection