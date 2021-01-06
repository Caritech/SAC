<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user =
            DB::table('users')
            ->selectRaw('users.*')
            ->where('users.id', Auth::id())
            ->first();

        return view('my_profile', compact('user'));
    }

    public function create()
    {
        abort(404);
    }
    public function update(Request $request)
    {
        $data = $request->input();
        $id =  \Auth::user()->id;
        $request->validate([
            'old_password' => 'nullable',
            'new_password' => 'required_with:old_password|confirmed|min:6|nullable',
            'email' => "required|email|unique:users,email,$id",
            'name' => "required",
        ]);
        $user = User::findOrFail(\Auth::user()->id);
        if ($request->old_password != null && \Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => \Hash::make($request->new_password)
            ])->save();
        } else if ($request->old_password != null && !\Hash::check($request->old_password, $user->password)) {
            $request->session()->flash('error', 'Old Password does not match');
            return redirect()->back();
        }

        $user->fill($data)->save();
        if ($request->hasFile('profile_image')) {
            $profile_image = saveImg($request, 'profile_image/' . $id, 'profile_image');
            $user->fill(['profile_image' => $profile_image])->save();
        }
        $request->session()->flash('success', 'Profile have been updated');
        return redirect()->back();
    }
}
