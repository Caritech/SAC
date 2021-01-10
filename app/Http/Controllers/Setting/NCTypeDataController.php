<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use App\Classes\Lists;

class NCTypeDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = DB::Table('vlife_maintenance_nc_type_data')->get();

        return view('maintenance.nc_type_data_view', compact('data'));
    }
    public function create()
    {
        $lists_nc_category = Lists::nc_category();
        return view('maintenance.nc_type_data_form', compact('lists_nc_category'));
    }

    public function store(Request $request)
    {
        DB::table('vlife_maintenance_nc_type_data')
            ->insert([
                'category' => $request->category,
                'type_code' => $request->type_code,
                'type_name' => $request->type_name,
            ]);

        return redirect()->back();
    }
}
