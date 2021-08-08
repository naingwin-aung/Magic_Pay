@extends('frontend.layouts.app')
@section('title', 'Transaction')
    
@section('content')
    @if (count($transactions))
        <div class="transaction mb-5">
            <div class="card mb-3">
                <div class="card-body py-3">
                    <h6 class="font-weight-bold"><i class="fas fa-filter"></i> Filter</h6>
                    <div class="row">
                        <div class="col-6 pl-2 pr-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label for="date" class="input-group-text p-1">Date</label>
                                </div>
                                <input type="text" class="form-control date" value="{{request()->date}}">
                            </div>
                        </div>
                        <div class="col-6 pl-2 pr-1">
                            <div class="input-group">
                                <select class="custom-select type">
                                    <option value="">All</option>
                                    <option value="1" @if (request()->type == 1) selected @endif>Income</option>
                                    <option value="2" @if (request()->type == 2) selected @endif>Expense</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h6 class="font-weight-bold ml-1">Transactions</h6>
            <div class="infinite_scroll">
                @foreach ($transactions as $transaction)
                    <a href="{{route('transaction.detail', $transaction->trx_id)}}">
                        <div class="card shadow mb-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h6 class="font-weight-bold">Trx Id: {{$transaction->trx_id}}</h6>
                                    @if ($transaction->type == 1)
                                        <h6 class="text-success font-weight-bold">+{{number_format($transaction->amount, 2)}} <small>MMK</small></h6>
                                    @elseif($transaction->type == 2)
                                        <h6 class="text-danger font-weight-bold">-{{number_format($transaction->amount, 2)}} <small>MMK</small></h6>
                                    @endif
                                </div>
                                <p class="text-muted mb-0">
                                    @if ($transaction->type == 1)
                                        From - 
                                    @elseif($transaction->type == 2)
                                        To - 
                                    @endif
                                    {{$transaction->source ? $transaction->source->name : ''}}
                                </p>
                                <p class="text-muted mb-0">
                                    {{$transaction->created_at->diffForHumans()}} - 
                                    {{$transaction->created_at->toFormattedDateString()}} -
                                    {{$transaction->created_at->format('H:i:s')}}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
                <div class="d-none">
                    {{$transactions->links()}}
                </div>
            </div>
        </div>
    @else
        <div class="text-center">
            <h5>No Transactions</h5>
        </div>
    @endif
@endsection
@section('script')
    <script>
        $('ul.pagination').hide();
        $(function() {
            $('.infinite_scroll').jscroll({
                autoTrigger: true,
                loadingHtml: '<div class="text-primary">Loading......</div>',
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite_scroll',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });

            $('.date').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "locale" : {
                    "format" : 'YYYY/MM/DD'
                }
            });

            $('.date').on('apply.daterangepicker', function(ev, picker) {
                let date = $('.date').val();
                let type = $('.type').val();

                history.pushState(null, '', `?date=${date}&type=${type}`);
                window.location.reload();
            });

            $('.type').on('change', function(){
                let date = $('.date').val();
                let type = $('.type').val();

                history.pushState(null, '', `?date=${date}&type=${type}`);
                window.location.reload();
            })
        });

    </script>
@endsection