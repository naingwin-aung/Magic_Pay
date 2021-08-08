@extends('backend.layouts.app')

@section('title', 'Admin User Management')
@section('admin-active', 'mm-active')
    
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Admin User Management</div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-body p-5">

                        @include('backend.layouts.flash')

                        <form action="{{route('admin.admin.update', $admin->id)}}" method="POST" id="update">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" value="{{old('name', $admin->name)}}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" value="{{old('email', $admin->email)}}">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="number" class="form-control" name="phone" value="{{old('phone', $admin->phone)}}">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password">
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdateAdminUserRequest', '#update') !!}
@endsection