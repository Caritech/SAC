<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use App\Models\HistoryLog;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $coordinate = $request->coordinate;

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $this->LogLocationToHistory($coordinate);
            return redirect()->intended($this->redirectPath());
        } elseif (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            $this->LogLocationToHistory($coordinate);
            return redirect()->intended($this->redirectPath());
        } else {
            return redirect()->back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors([
                    'username' => 'Incorrect username or password',
                ]);
        }
    } //End of overided login function

    public function LogLocationToHistory($coordinate)
    {
        $change_txt = "coordinate:$coordinate\nIpAddress:" . getRealIpAddr();
        $arr = [
            'task' => 'Insert',
            'application' => 'User Login - Log Location',
            'summary' => 'Coordinate: ' . $coordinate,
            'change_txt' => $change_txt,
        ];
        HistoryLog::insertHistory($arr);
    }
}
