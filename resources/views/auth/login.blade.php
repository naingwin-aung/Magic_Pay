@extends('frontend.layouts.app_plain')

@section('content')
<div class="auth__theme">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-md-8">
                <div class="card shadow p-3">
                    <div class="card-body">
                        <h3 class="text-primary">Login</h3>
                        <p class="text-muted">Your Account</p>
                        <form method="POST" action="{{ route('login') }}"> 
                            @csrf
    
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>
    
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            <div class="form-group auth__password">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control password @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <i class="fas fa-eye ps-show-hide"></i>
    
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
    
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    @if (Route::has('password.request'))
                                        <a class="mt-2 font-weight-bold" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
    
                                    <button type="submit" class="auth__btn">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-4 text-center font-weight-bold register">
                    <a href="{{route('register')}}">
                        Create A New Account
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            const pswrdField = document.querySelector('.password'),
                toggleBtn = document.querySelector('.ps-show-hide');

            $(toggleBtn).on('click', function() {
                if(pswrdField.type == 'password') {
                    pswrdField.type = 'text';
                    $('.ps-show-hide').addClass('active');
                } else {
                    pswrdField.type = 'password';
                    $('.ps-show-hide').removeClass('active');
                }
            })
        })
    </script>
@endsection
