@extends('backend.layouts.app')

@section('title', 'User Management')
@section('user-active', 'mm-active')
    
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-user icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>User Management</div>
        </div>
    </div>
</div>
<div class="content">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-body p-5">

                    @include('backend.layouts.flash')

                    <form action="{{route('admin.user.store')}}" method="POST" id="create">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="{{old('email')}}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="number" class="form-control" name="phone" value="{{old('phone')}}">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control ps-show-hide" name="password">
                        </div>
                        <div class="form-group">
                            <label for="password">Confirm Password</label>
                            <input type="password" class="form-control ps-show-hide" name="password_confirmation">
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                    <label class="form-check-label" for="remember">
                                        {{ __('Show Password') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-5">
                            <button class="btn btn-secondary back-btn">Back</button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\StoreUserRequest', '#create') !!}

    <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').click(function(){
                const pswrdField = document.querySelectorAll('.ps-show-hide');

                if($(this).is(":checked") == true){
                    pswrdField.forEach(pass => {
                        if(pass.type == 'password') {
                            pass.type = "text";
                        }
                    });
                }
                else if($(this).is(":checked") == false){
                    pswrdField.forEach(pass => {
                        if(pass.type == 'text') {
                            pass.type = "password";
                        }
                    });
                }
            });
        })
    </script>
@endsection