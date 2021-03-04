<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'web', 'developer_access']);
    }

    public function index()
    {
        return view('developer_page');
    }

    public function config_cache(Request $request)
    {
        \Artisan::call('config:cache');
        $request->session()->flash('status', 'Cache Cleared');
        return redirect()->back();
    }
}
