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
        <a href="{{route('admin.admin.create')}}" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i>
            Create Admin User
        </a>
    
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered datatable" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th class="no-sort">Ip</th>
                            <th class="no-sort">User Agent</th>
                            <th>Created_at</th>
                            <th>Updated_at</th>
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
            processing: true,
            serverSide: true,
            ajax: "/admin/admin-user/datatable/ssd",
            columns : [
                {
                    data : "name",
                    name : "name",
                },
                {
                    data : "email",
                    name : "email",
                    sortable : false
                },
                {
                    data : "phone",
                    name : "phone",
                    sortable : false
                },
                {
                    data : "ip",
                    name : "ip",
                },
                {
                    data : "user_agent",
                    name : "user_agent",
                },
                {
                    data : "created_at",
                    name : "created_at",
                    searchable : false
                },
                {
                    data : "updated_at",
                    name : "updated_at",
                    searchable : false
                },
                {
                    data : "action",
                    name : "action"
                }
            ],
            order: [
                [ 6, "desc" ]
            ],
            columnDefs: [{
                targets: 'no-sort',
                searchable: false,
                sortable : false,
            }]
        });

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
                        url : `/admin/admin/${id}`,
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
    } );
</script>
@endsection