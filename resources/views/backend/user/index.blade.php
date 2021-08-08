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
    <a href="{{route('admin.user.create')}}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i>
        Create User
    </a> 
    
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered datatable" style="width : 100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="no-sort">Ip</th>
                        <th class="no-sort">User Agent</th>
                        <th>Login At</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            let table = $('.datatable').DataTable({
                processing : true,
                serverSide : true,
                ajax : '/admin/user/datatable/ssd',
                columns : [
                    {
                        data : 'name',
                        name : 'name'
                    },
                    {
                        data : 'email',
                        name : 'email',
                        sortable : false
                    },
                    {
                        data : 'phone',
                        name : 'phone',
                        sortable : false
                    },
                    {
                        data : 'ip',
                        name : 'ip'
                    },
                    {
                        data : 'user_agent',
                        name : 'user_agent'
                    },
                    {
                        data : 'login_at',
                        name : 'login_at',
                        searchable : false
                    },
                    {
                        data : 'created_at',
                        name : 'created_at',
                        searchable : false
                    },
                    {
                        data : 'updated_at',
                        name : 'updated_at',
                        searchable : false
                    },
                    {
                        data : 'action',
                        name : 'action'
                    },
                ],
                order: [
                    [ 7, "desc" ]
                ],
                columnDefs: [{
                    targets: 'no-sort',
                    searchable: false,
                    sortable : false,
                }]
            })

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                
                Swal.fire({
                title: 'Are you sure?',
                text: "You want to Delete",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5842E3',
                cancelButtonColor: '#d33',
                reverseButtons : true,
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : `/admin/user/${id}`,
                        type : 'DELETE',
                        success : function(res) {
                            if(res.status == 'success') {
                                table.ajax.reload();
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Deleted successfully'
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