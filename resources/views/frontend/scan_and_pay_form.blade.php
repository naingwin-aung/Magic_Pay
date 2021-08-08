@extends('frontend.layouts.app')
@section('title', 'Scan & Pay')
    
@section('content')
    <div class="scan_and_pay">
        <div class="card shadow">
            <div class="card-body"> 
                <h5>From - <span class="text-uppercase">{{$from_account->name}}</span></h5>
                <p class="text-muted">{{$from_account->phone}}</p>
                <hr>

                @include('frontend.layouts.flash')

                <form action="{{route('scanAndPayConfirm')}}" method="GET" id="transfer" autocomplete="off">
                    <input type="hidden" name="hash_value" class="hash_value" value="">
                    <input type="hidden" name="to_phone" class="to_phone" value="{{$to_account->phone}}">
                    <div class="form-group">
                        <label for="to">To <span class="to-account-fail text-danger"></span><span class="to-account-success text-success"></span></label>
                        <p>{{$to_account->phone}} <span class="text-success">({{$to_account->name}})</span></p>
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