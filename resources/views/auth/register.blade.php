@extends('frontend.layouts.app_plain')

@section('content')
<div class="auth__register">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-md-8">
                <div class="card shadow p-3">
                    <div class="card-body">
                        <h3 class="text-primary">Register</h3>
                        <p class="text-muted">Created a New Account</p>

                        @include('frontend.layouts.flash')
                        
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
    
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </div>
    
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
    
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input id="phone" type="number" class="form-control" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                            </div>
    
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control ps-show-hide" name="password" required autocomplete="new-password">
                            </div>
    
                            <div class="form-group">
                                <label for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control ps-show-hide" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="form-group row mt-4">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
    
                                        <label class="form-check-label" for="remember">
                                            Show Password
                                        </label>
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group mt-4">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{route('login')}}" class="font-weight-bold">Already have an account?</a>
                                    </div>
                                    <button type="submit" class="auth__btn">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\StoreRegisterRequest') !!}
    <script>
        $(document).ready(function() {
            let pswrdField = document.querySelectorAll('.ps-show-hide');

            $('input[type=checkbox]').on('click', function() {
               if($(this).is(":checked") == true) {
                   pswrdField.forEach(pass => {
                       if(pass.type == 'password') {
                           pass.type = 'text';
                       }
                   });
                }
                else if($(this).is("checked") == false) {
                    pswrdField.forEach(pass => {
                       if(pass.type == 'text') {
                           pass.type = 'password';
                       }
                   });
                }
            })
        })
    </script>
@endsection
