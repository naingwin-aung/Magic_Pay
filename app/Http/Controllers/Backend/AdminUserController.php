<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUserRequest;
use App\Http\Requests\UpdateAdminUserRequest;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('backend.admin-user.index');
    }

    public function create()
    {
        return view('backend.admin-user.create');
    }

    public function store(StoreAdminUserRequest $request)
    {
        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.admin.index')->with('created', 'Successfully Created');
    }

    public function edit(Admin $admin)
    {
        return view('backend.admin-user.edit', compact('admin'));
    }

    public function update(UpdateAdminUserRequest $request, $id)
    {
        if($request->password && Str::length($request->password) < 6) {
            return back()->withErrors(['fails' => 'လျှို့ ဝှက်နံပါတ်သည်အနည်းဆုံး ၆ လုံးပါဝင်ရမည်။'])->withInput();
        }

        $admin = Admin::findOrFail($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->password = $request->password ? Hash::make($request->password) : $admin->password;
        $admin->save();

        return redirect()->route('admin.admin.index')->with('updated', 'Successfully Updated');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'successfully deleted'
        ]);
    }

    public function serverSideData()
    {
        $admin = Admin::query();

        return datatables($admin)
        ->editColumn('user_agent', function($each) {
            if($each->user_agent) {
                $agent = new Agent();
                $agent->setUserAgent($each->user_agent);
                $device = $agent->device();
                $platform = $agent->platform();
                $browser = $agent->browser();

                return '<table class="table table-bordered">
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
                </table>';
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
        ->addColumn('action', function($each) {
            if($each->id == Auth::guard('admin')->user()->id) {
                $edit_icon = '<a href="'.route('admin.admin.edit', $each->id).'" class="text-warning mr-2"><i class="fas fa-edit"></i></a>';
                return $edit_icon;
            }

            $edit_icon = '<a href="'.route('admin.admin.edit', $each->id).'" class="text-warning mr-2"><i class="fas fa-edit"></i></a>';
            $delete_icon = '<a href="#" class="text-danger delete" data-id="'.$each->id.'"><i class="fas fa-trash"></i></a>';

            return $edit_icon . $delete_icon;
        })
        ->rawColumns(['user_agent', 'action'])
        ->toJson();
    }
}
