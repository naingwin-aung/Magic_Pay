@extends('frontend.layouts.app')
@section('title', 'Update Password')

@section('content')
   <div class="update_password mb-5">
       <div class="card shadow">
            <div class="card-body">

                @include('frontend.layouts.flash')
                <div class="text-center">
                    <img src="{{asset('frontend/img/update_password.png')}}" alt="change password">
                </div>

                <form action="{{route('update-password')}}" method="POST" id="update" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="current">Current Password</label>
                        <input type="password" class="form-control" name="current_password">
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control ps-show-hide" name="password">
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <input type="password" class="form-control ps-show-hide" name="password_confirmation">
                    </div>


                    <div class="d-flex justify-content-between mt-4">
                        <div class="form-group row mt-1">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                    <label class="form-check-label" for="remember">
                                        {{ __('Show Password') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary">
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
       </div>
   </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\UpdateCheckPasswordRequest', '#update') !!}

   <script>
       $(document).ready(function() {
           $('input[type="checkbox"]').on('click', function() {
               let pswrdField = document.querySelectorAll('.ps-show-hide');

               if($(this).is(":checked") == true) {
                    pswrdField.forEach(pass => {
                       if(pass.type == 'password') {
                           pass.type = 'text';
                       } 
                    });
               } else if($(this).is(":checked") == false) {
                    pswrdField.forEach(pass => {
                        pass.type = 'password';
                    });
               }
           })
       })
   </script>
@endsection
