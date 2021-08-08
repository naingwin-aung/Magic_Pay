<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function home()
    {
        return view("backend.wallet.index");
    }

    public function serverSideData()
    {
        $wallet = Wallet::with('user');

        return datatables($wallet)
        ->addColumn('account_person', function($each) {
            $user = $each->user;

            if($user) {
                return '
                    <p>Name: ' .$user->name. ' </p>
                    <p>Email: ' .$user->email. ' </p>
                    <p>Phone: ' .$user->phone. ' </p>
                ';
            }
        })
        ->editColumn('amount', function($each) {
            if($each->amount != 0) {
                return number_format($each->amount, 2) . ' MMK';
            }

            return '-';
        })
        ->editColumn('created_at', function($each) {
            return Carbon::parse($each->created_at)->diffForHumans(). ' - ' .
                Carbon::parse($each->created_at)->toFormattedDateString(). ' - ' .
                Carbon::parse($each->created_at)->format('H:i:s')
            ;
        })
        ->editColumn('updated_at', function($each) {
            return Carbon::parse($each->updated_at)->diffForHumans(). ' - ' .
                Carbon::parse($each->updated_at)->toFormattedDateString(). ' - ' .
                Carbon::parse($each->updated_at)->format('H:i:s')
            ;
        })
        ->rawColumns(['account_person'])
        ->toJson();
    }
}
