<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (\Auth::user()->role == 1) {
                abort(404);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $search_input = $request->input('search_input');
        $sort = $request->input('sort');
        $direction = $request->input('direction');
        $data = DB::table('users')
            ->selectRaw('
                id,
                name,
                username,
                email,
                status,
                created_at,
                updated_at
                ');
        if ($search_input != null && $search_input != '') {
            $data->where(function ($a) use ($search_input) {
                $a->where('name', 'like', '%' . $search_input . '%')
                    ->orWhere('email', 'like', '%' . $search_input . '%')
                    ->orWhere('username', 'like', '%' . $search_input . '%');
            });
        }

        if ($sort != null && $direction != null) {
            $data = $data->orderBy($sort, $direction);
        }
        $data = $data->paginate(20);
        return view('user_management', compact('data',  'search_input'));
    }
    public function edit($id)
    {
        $action = "Edit";
        $users = DB::table('users')
            ->where('id', '=', $id)
            ->first();

        $data = new \stdClass();
        $data->users = $users;
        //dd($data);
        //$data->users->roles = explode(',', $data->users->roles);
        return view('user_management_form', compact('id', 'data', 'action'));
    }
    public function create()
    {
        $action = "Add";

        return view('user_management_form', compact('action'));
    }
    public function store(Request $request)
    {
        $validation = [
            'users.username' => "required|unique:users,username",
            'users.email' => "required|email|unique:users,email",
            'users.name' => "required",
            'users.password' => "required",
            'users.role' => "required",
        ];
        $messages = [
            'users.username.required' => 'The username field is required.',
            'users.username.unique' => 'The username has already been taken.',
            'users.email.required' => 'The email field is required.',
            'users.email.email' => 'The email must be a valid email address.',
            'users.email.unique' => 'The email has already been taken.',
            'users.name.required' => 'The name field is required.',
            'users.password.required' => 'The password field is required.',
            'users.role.required' => 'The roles field is required.'
        ];
        $validator = Validator::make($request->all(), $validation, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $post = $request->input();
        $user = $post['users'];
        $user['password'] = bcrypt($user['password']);
        // if (isset($user['roles'])) {
        //     $user['roles'] = implode(',', $user['roles']);
        //  }
        $users = User::create($user);
        $id = $users->id;
        if ($request->hasFile('profile_image')) {
            $profile_image = saveImg($request, 'profile_image/' . $id, 'profile_image');
            User::find($id)->fill(['profile_image' => $profile_image])->save();
        }
        if ($user['role'] == "1") {
            $request->session()->flash('success', 'New user has been added.');
        } else {
            $request->session()->flash('success', 'New admin has been added.');
        }
        return redirect('/admin/user_management');
    }
    public function update(Request $request, $id)
    {
        $validation = [
            'users.username' => "required|unique:users,username,$id",
            'users.email' => "required|email|unique:users,email,$id",
            'users.name' => "required",
            'users.role' => "required",
        ];
        $messages = [
            'users.username.required' => 'The username field is required.',
            'users.username.unique' => 'The username has already been taken.',
            'users.email.required' => 'The email field is required.',
            'users.email.email' => 'The email must be a valid email address.',
            'users.email.unique' => 'The email has already been taken.',
            'users.name.required' => 'The name field is required.',
            'users.role.required' => 'The roles field is required.'
        ];
        $validator = Validator::make($request->all(), $validation, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $post = $request->input();
        $user = $post['users'];
        User::find($id)->fill($user)->save();

        if ($request->hasFile('profile_image')) {
            $profile_image = saveImg($request, 'profile_image/' . $id, 'profile_image');
            User::find($id)->fill(['profile_image' => $profile_image])->save();
        }


        if ($user['role'] == "1") {
            $request->session()->flash('success', 'User has been updated.');
        } else {
            $request->session()->flash('success', 'Admin has been updated.');
        }
        return redirect()->back();
    }

    /*public function Cloak($id = null)
    {
        if (!\Auth::check()) {
            return redirect('/');
        }

        $cloak_user = User::find($id);
        \Session::put('cloak_user', \Auth::id());
        \Auth::login($cloak_user);
        return redirect('/');
    }
    public function unCloak()
    {
        $id = \Session::get('cloak_user');
        if ($id == null) {
            return redirect('/');
        }
        $user = User::find($id);
        \Auth::login($user);
        \Session::forget('cloak_user');
        return redirect('/admin');
    }*/
}
