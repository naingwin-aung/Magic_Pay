<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Helper\UUIDGenerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\TransferFormRequest;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\UpdateCheckPasswordRequest;

class PageController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }

    public function profile()
    {
        return view('frontend.profile');
    }

    public function updatePasswordForm()
    {
        return view('frontend.update_password');
    }

    public function updatePassword(UpdateCheckPasswordRequest $request)
    {
        $user = Auth::user();

        if(!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['fail' => 'လျိူ့ဝှက်နံပါတ် မှားယွင်းနေပါသည်။'])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $title = "Change Password";
        $message = "Your Account Password is successfully changed!";
        $sourceable_id = $user->id;
        $sourceable_type = User::class;
        $web_link = url('profile');
        $deep_link = [
            'target' => 'profile',
            'parameter' => null,
        ];

        Notification::send($user, new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link, $deep_link));

        return redirect()->route('profile')->with('update_password', 'လျှို့ ဝှက်နံပါတ် ပြောင်းလဲပြီးပါပီ။');
    }

    public function wallet()
    {
        $user = Auth::user();
        return view('frontend.wallet', compact('user'));
    }

    public function transferForm()
    {
        $user = Auth::user();
        return view('frontend.transfer', compact('user'));
    }

    public function toVerifyAccount(Request $request)
    {
        $from_account = Auth::user();
        $to_account = User::where('phone', $request->to_phone)->first();

        if(!$to_account) {
            return response()->json([
                'status' => 'fail',
                'message' => 'ငွေလွှဲလိုသောဖုန်းနံပါတ် မှားယွင်းနေပါသည်။'
            ]);
        }

        if($to_account->phone == $from_account->phone) {
            return response()->json([
                'status' => 'fail',
                'message' => 'ငွေလွှဲလိုသောဖုန်းနံပါတ်သည် မိမိဖုန်းနံပါတ်မဖြစ်ရပါ။'
                
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $to_account,
        ]);
    }

    public function transferHash(Request $request)
    {
        $hash_value = hash_hmac('sha256', $request->to_phone.$request->amount.$request->description , 'magicpay123!@#'); 

        return response()->json([
            'status' => 'success',
            'data' => $hash_value
        ]);
    }
    
    public function transferConfirmForm(TransferFormRequest $request)
    {
        $hash_value2 = hash_hmac('sha256', $request->to_phone.$request->amount.$request->description , 'magicpay123!@#');

        if($request->hash_value !== $hash_value2) {
            return redirect()->route('transfer')->with('security', 'The given data isn\'t be secure!');
        }

        $from_account = Auth::user();
        $to_account = User::where('phone', $request->to_phone)->first();

        if($from_account->wallet->amount < $request->amount){
            return back()->withErrors(['fail' => 'ငွေလွှဲလိုသောပမာဏ မလုံလောက်ပါ။'])->withInput();
        }

        if($to_account && $to_account->phone !== $from_account->phone) {
            $amount = $request->amount;
            $description = $request->description;
            $hash_value = $request->hash_value;

            return view('frontend.transfer_confirm', compact('hash_value', 'from_account', 'to_account', 'amount', 'description'));
        }

        return back()->withErrors(['fail' => 'ငွေလွှဲလိုသောဖုန်းနံပါတ် မှားယွင်းနေပါသည်။'])->withInput();
    }

    public function transferComplete(TransferFormRequest $request)
    {
        $hash_value2 = hash_hmac('sha256', $request->to_phone.$request->amount.$request->description , 'magicpay123!@#');

        if($request->hash_value !== $hash_value2) {
            return redirect()->route('transfer')->with('security', 'The given data isn\'t be secure!');
        }

        $from_account = Auth::user();
        $to_account = User::where('phone', $request->to_phone)->first();

        if($from_account->wallet->amount < $request->amount){
            return back()->withErrors(['fail' => 'ငွေလွှဲလိုသောပမာဏ မလုံလောက်ပါ။'])->withInput();
        }

        if($to_account && $to_account->phone !== $from_account->phone) {
            $amount = $request->amount;
            $description = $request->description;

            if(!$from_account->wallet && !$to_account->wallet) {
                return back()->withErrors(['fail' => 'Something Wrong. The given data is invalid'])->withInput();
            }

            DB::beginTransaction();

            try {
                $from_account->wallet->decrement('amount', $amount);
                $from_account->wallet->update();
                
                $to_account->wallet->increment('amount', $amount);
                $to_account->wallet->update();

                $ref_no = UUIDGenerate::refNumber();

                $from_account_transaction = new Transaction();
                $from_account_transaction->ref_no = $ref_no;
                $from_account_transaction->trx_id = UUIDGenerate::trxId();
                $from_account_transaction->user_id = $from_account->id;
                $from_account_transaction->type = 2;
                $from_account_transaction->amount = $amount;
                $from_account_transaction->source_id = $to_account->id;
                $from_account_transaction->description = $description;
                $from_account_transaction->save();

                $to_account_transaction = new Transaction();
                $to_account_transaction->ref_no = $ref_no;
                $to_account_transaction->trx_id = UUIDGenerate::trxId();
                $to_account_transaction->user_id = $to_account->id;
                $to_account_transaction->type = 1;
                $to_account_transaction->amount = $amount;
                $to_account_transaction->source_id = $from_account->id;
                $to_account_transaction->description = $description;
                $to_account_transaction->save();

                //From Noti
                $title = 'Money Transfered!';
                $message = 'Your wallet transfered ' . number_format($amount) . ' MMK to '. $to_account->name . ' ('. $to_account->phone .')';
                $sourceable_id = $from_account_transaction->id; 
                $sourceable_type = Transaction::class; 
                $web_link = url('/transaction/detail/' . $from_account_transaction->trx_id);
                $deep_link = [
                    'target' => 'transaction_detail',
                    'parameter' => [
                        'trx_id' => $from_account_transaction->trx_id,
                    ],
                ];
        
                Notification::send([$from_account], new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link, $deep_link));

                //To Noti
                $title = 'Money Received!';
                $message = 'Your wallet received ' . number_format($amount) . ' MMK from '.                 $from_account->name . ' ('. $from_account->phone .')';
                $sourceable_id = $to_account_transaction->id; 
                $sourceable_type = Transaction::class; 
                $web_link = url('/transaction/detail/' . $to_account_transaction->trx_id);
                $deep_link = [
                    'target' => 'transaction_detail',
                    'parameter' => [
                        'trx_id' => $to_account_transaction->trx_id,
                    ],
                ];
        
                Notification::send([$to_account], new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link, $deep_link));

                DB::commit();
                return redirect()->route('transaction.detail', $from_account_transaction->trx_id)->with('success', 'အောင်မြင်ပါသည်။');
            } catch (\Exception $e) {
                DB::rollback();
                return back()->withErrors(['fails' => 'Something Wrong'])->withInput();
            }
        }

        return back()->withErrors(['fail' => 'ငွေလွှဲလိုသောဖုန်းနံပါတ် မှားယွင်းနေပါသည်။'])->withInput();
    }

    public function passwordCheck(Request $request)
    {
        if(!$request->password) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Please fill your password!'
            ]);
        }

        $user = Auth::user();
        if(Hash::check($request->password, $user->password)) {
           return response()->json([
                'status' => 'success',
                'message' => 'The password is correct.'
            ]);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Password is not correct'
        ]);
    }

    public function receiveQr()
    {
        $user = Auth::user();
        return view('frontend.receive_qr', compact('user'));
    }

    public function transaction(Request $request)
    {
        $user = Auth::user();
        $transactions = Transaction::with('user', 'source')->where('user_id', $user->id)->orderBy('created_at', 'DESC');

        if($request->type) {
            $transactions = $transactions->where('type', $request->type);
        }

        if($request->date) {
            $transactions = $transactions->whereDate('created_at', $request->date);
        }

        $transactions = $transactions->paginate(5);

        return view('frontend.transaction', compact('transactions'));
    }

    public function transactionDetail($trx_id)
    {
        $user = Auth::user();
        $transaction = Transaction::with('user', 'source')->where('user_id', $user->id)->where('trx_id', $trx_id)->first();
        return view('frontend.transaction_detail', compact('transaction'));
    }

    public function scanAndPay()
    {
        return view('frontend.scan_and_pay');
    }

    public function scanAndPayForm(Request $request)
    {
        $from_account = Auth::user();
        $to_account = User::where('phone', $request->to_phone)->first();

        if($to_account && $to_account->phone !== $from_account->phone) {
            return view('frontend.scan_and_pay_form', compact('from_account', 'to_account'));
        }
        return back()->withErrors(['fail' => 'ငွေလွှဲလိုသော နံပါတ်မှားယွင်းနေပါသည်။'])->withInput();
    }
    
    public function scanAndPayConfirm(TransferFormRequest $request)
    {
        $hash_value2 = hash_hmac('sha256', $request->to_phone.$request->amount.$request->description , 'magicpay123!@#');

        if($request->hash_value !== $hash_value2) {
            return redirect()->route('scanAndPay')->with('scan-security', 'The given data isn\'t be secure!');
        }

        $from_account = Auth::user();
        $to_account = User::where('phone', $request->to_phone)->first();

        if($from_account->wallet->amount < $request->amount){
            return back()->withErrors(['fail' => 'ငွေလွှဲလိုသောပမာဏ မလုံလောက်ပါ။'])->withInput();
        }

        if($to_account && $to_account->phone !== $from_account->phone) {
            $amount = $request->amount;
            $description = $request->description;
            $hash_value = $request->hash_value;

            return view('frontend.scan_and_pay_confirm', compact('hash_value', 'from_account', 'to_account', 'amount', 'description'));
        }

        return back()->withErrors(['fail' => 'ငွေလွှဲလိုသောဖုန်းနံပါတ် မှားယွင်းနေပါသည်။'])->withInput();
    }

    public function scanAndPayComplete(TransferFormRequest $request)
    {
        $hash_value2 = hash_hmac('sha256', $request->to_phone.$request->amount.$request->description , 'magicpay123!@#');

        if($request->hash_value !== $hash_value2) {
            return redirect()->route('scanAndPay')->with('scan-security', 'The given data isn\'t be secure!');
        }

        $from_account = Auth::user();
        $to_account = User::where('phone', $request->to_phone)->first();

        if($from_account->wallet->amount < $request->amount){
            return back()->withErrors(['fail' => 'ငွေလွှဲလိုသောပမာဏ မလုံလောက်ပါ။'])->withInput();
        }

        if($to_account && $to_account->phone !== $from_account->phone) {
            $amount = $request->amount;
            $description = $request->description;

            if(!$from_account->wallet && !$to_account->wallet) {
                return back()->withErrors(['fail' => 'Something Wrong. The given data is invalid'])->withInput();
            }

            DB::beginTransaction();

            try {
                $from_account->wallet->decrement('amount', $amount);
                $from_account->wallet->update();
                
                $to_account->wallet->increment('amount', $amount);
                $to_account->wallet->update();

                $ref_no = UUIDGenerate::refNumber();

                $from_account_transaction = new Transaction();
                $from_account_transaction->ref_no = $ref_no;
                $from_account_transaction->trx_id = UUIDGenerate::trxId();
                $from_account_transaction->user_id = $from_account->id;
                $from_account_transaction->type = 2;
                $from_account_transaction->amount = $amount;
                $from_account_transaction->source_id = $to_account->id;
                $from_account_transaction->description = $description;
                $from_account_transaction->save();

                $to_account_transaction = new Transaction();
                $to_account_transaction->ref_no = $ref_no;
                $to_account_transaction->trx_id = UUIDGenerate::trxId();
                $to_account_transaction->user_id = $to_account->id;
                $to_account_transaction->type = 1;
                $to_account_transaction->amount = $amount;
                $to_account_transaction->source_id = $from_account->id;
                $to_account_transaction->description = $description;
                $to_account_transaction->save();

                //From Noti
                $title = 'Money Transfered!';
                $message = 'Your wallet transfered ' . number_format($amount) . ' MMK to '. $to_account->name . ' ('. $to_account->phone .')';
                $sourceable_id = $from_account_transaction->id; 
                $sourceable_type = Transaction::class; 
                $web_link = url('/transaction/detail/' . $from_account_transaction->trx_id);
                $deep_link = [
                    'target' => 'transaction_detail',
                    'parameter' => [
                        'trx_id' => $from_account_transaction->trx_id,
                    ],
                ];
        
                Notification::send([$from_account], new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link, $deep_link));

                //To Noti
                $title = 'Money Received!';
                $message = 'Your wallet received ' . number_format($amount) . ' MMK from '. $from_account->name . ' ('. $from_account->phone .')';
                $sourceable_id = $to_account_transaction->id; 
                $sourceable_type = Transaction::class; 
                $web_link = url('/transaction/detail/' . $to_account_transaction->trx_id);
                $deep_link = [
                    'target' => 'transaction_detail',
                    'parameter' => [
                        'trx_id' => $to_account_transaction->trx_id,
                    ],
                ];
        
                Notification::send([$to_account], new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link, $deep_link));

                DB::commit();
                return redirect()->route('transaction.detail', $from_account_transaction->trx_id)->with('success', 'အောင်မြင်ပါသည်။');
            } catch (\Exception $e) {
                DB::rollback();
                return back()->withErrors(['fails' => 'Something Wrong'])->withInput();
            }
        }

        return back()->withErrors(['fail' => 'ငွေလွှဲလိုသောဖုန်းနံပါတ် မှားယွင်းနေပါသည်။'])->withInput();
    }
}
