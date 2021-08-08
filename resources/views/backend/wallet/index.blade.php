@extends('backend.layouts.app')

@section('title', 'Wallet')
@section('wallet-active', 'mm-active')
    
@section('content')
<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-wallet icon-gradient bg-mean-fruit">
                </i>
            </div>
            <div>Wallet</div>
        </div>
    </div>
</div>
<div class="content">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered datatable" style="width : 100%">
                <thead>
                    <tr>
                        <th class="no-sort">Account Person</th>
                        <th>Account Number</th>
                        <th>Amount</th>
                        <th>Created At</th>
                        <th>Updated At</th>
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
                ajax : '/admin/wallet/datatable/ssd',
                columns : [
                    {
                        data : 'account_person',
                        name : 'account_person'
                    },
                    {
                        data : 'account_number',
                        name : 'account_number',
                        sortable : false
                    },
                    {
                        data : 'amount',
                        name : 'amount'
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
                ],
                order: [
                    [ 4, "desc" ]
                ],
                columnDefs: [{
                    targets: 'no-sort',
                    searchable: false,
                    sortable : false,
                }]
            })
        })
    </script>    
@endsection