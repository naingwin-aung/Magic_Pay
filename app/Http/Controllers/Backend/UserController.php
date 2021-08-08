<?php

namespace App\Http\Controllers\Backend;

use App\Helper\AccountNumberGenerate;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Wallet;

class UserController extends Controller
{
    public function index()
    {
        return view('backend.user.index');
    }

    public function create()
    {
        return view('backend.user.create');
    }

    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();
        
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            Wallet::firstOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'account_number' => AccountNumberGenerate::accountNumber(),
                    'amount' => 0
                ]
            );
            DB::commit();
    
            return redirect()->route('admin.user.index')->with('created', 'Successfully Created');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['fail' => "Something Wrong"])->withInput();
        }
    }

    public function edit(User $user)
    {
        return view("backend.user.edit", compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        if($request->password && Str::length($request->password) < 6) {
            return back()->withErrors(['fails' => 'လျှို့ ဝှက်နံပါတ်သည်အနည်းဆုံး ၆ လုံးပါဝင်ရမည်။'])->withInput();
        }
        
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;
        $user->save();

        return redirect()->route('admin.user.index')->with('updated', 'Successfully Updated');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'successfully deleted'
        ]);
    }

    public function serverSideData()
    {
        $user = User::query();

        return datatables($user)
        ->editColumn('user_agent', function($each) {
            if($each->user_agent) {
                $agent = new Agent();
                $agent->setUserAgent($each->user_agent);
                $device = $agent->device();
                $platform = $agent->platform();
                $browser = $agent->browser();

                return '
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Device</td>
                                <td>'.$device.'</td>
                            </tr>
                            <tr>
                                <td>Platform</td>
                                <td>'.$platform.'</td>
                            </tr>
                            <tr>
                                <td>Browser</td>
                                <td>'.$browser.'</td>
                            </tr>
                        </tbody>
                    </table>
                ';
            }
            return '-';
        })
        ->editColumn('login_at', function($each) {
            return Carbon::parse($each->login_at)->diffForHumans(). ' - ' .
                    Carbon::parse($each->login_at)->toFormattedDateString(). ' - ' .
                    Carbon::parse($each->login_at)->format('H:i:s')
            ;
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
        ->addColumn('action', function($each) {
            $edit_icon = '<a href="'.route('admin.user.edit', $each->id).'" class="text-warning mr-2"><i class="fas fa-edit"></i></a>';
            $delete_icon = '<a href="#" class="text-danger delete" data-id="'.$each->id.'"><i class="fas fa-trash"></i></a>';

            return $edit_icon . $delete_icon;
        })
        ->rawColumns(['user_agent', 'action'])
        ->toJson();
    }
}
