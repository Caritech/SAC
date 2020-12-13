<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;


class NCTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $data = DB::Table('vlife_nc_type')->get();
        return view('maintenance.nc_type_view', compact('data'));
    }

    public function create()
    {
        return view('maintenance.nc_type_form');
    }
    public function store(Request $request)
    {
        $post = $request->input();
        $name = $post['name'];

        DB::Table('vlife_nc_type')->insert(['name' => $name]);
        return redirect('/vlife/nc_type_maintenance');
    }
    public function edit(Request $request, $id)
    {
        //$data = DB::Table('vlife_nc_type')->first();
        //return view('maintenance.nc_sub_type_form');
    }
    public function update(Request $request, $id)
    {
    }
    public function destroy(Request $request, $id)
    {
    }
}
