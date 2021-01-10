<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use App\Classes\Lists;

class NCTypeCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data = DB::Table('vlife_maintenance_nc_type_category')->get();

        return view('maintenance.nc_type_category_view', compact('data'));
    }
    public function create()
    {
        $lists_nc_category = Lists::nc_category();
        return view('maintenance.nc_type_form', compact('lists_nc_category'));
    }
    public function edit($id)
    {
        $category = DB::table('vlife_maintenance_nc_type_category')->where('id', $id)->first();
        $category_code = $category->category_code;

        $data = DB::table('vlife_maintenance_nc_type_data')->where('category', $category_code)->get();

        return view('maintenance.nc_type_category_form', compact('data', 'category'));
    }

    public function store(Request $request)
    {
        DB::table('vlife_nc_type_maintenance')
            ->insert([
                'category' => $request->category,
                'type_code' => $request->type_code,
                'type_name' => $request->type_name,
                'type_name' => $request->type_name,
                'use_annual_income' => $request->use_annual_income,
                'multiply_annual_income' => $request->multiply_annual_income,
            ]);

        return redirect()->back();
    }
    public function update($id, Request $request)
    {
        $amount = $request->amount_prefered;
        $data = $request->input('type');

        DB::table('vlife_maintenance_nc_type_category')
            ->where('id', $id)
            ->update([
                'amount_prefered' => $amount,
                'use_annual_income' => $request->use_annual_income,
                'multiply_annual_income' => $request->multiply_annual_income,
            ]);

        foreach ($data as $k => $d) {
            DB::table('vlife_maintenance_nc_type_data')->where('id', $k)->update([
                'percentage_prefered' => $d['percentage_prefered']
            ]);
        }
        return redirect()->back();
    }
}
