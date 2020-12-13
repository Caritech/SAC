<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;

//MODEL TO USE
use App\Models\Contacts;
//insurance
use App\Models\Insurance;
use App\Models\Insurance\Coverage as InsuranceCoverage;
use App\Models\Insurance\ProjectedBenefit as InsuranceProjectedBenefit;
use App\Classes\Lists;
use App\Classes\VueTable;

class SummaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('maintenance.nc_sub_type_view');
    }

    public function create()
    {
        return view('maintenance.nc_sub_type_form');
    }
    public function store(Request $request)
    {
    }
    public function edit(Request $request, $id)
    {

        return view('maintenance.nc_sub_type_form');
    }
    public function update(Request $request, $id)
    {
    }
    public function destroy(Request $request, $id)
    {
    }
}
