<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;

//MODEL TO USE
use App\Models\Need_Calculator\Preference as NCPreference;
use App\Models\Need_Calculator\Medical as NCMedical;
use App\Models\Need_Calculator\DeathTpd as NCDeathTpd;
use App\Models\Need_Calculator\CriticalIllness as NCCriticalIllness;


class NeedsCalculatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_nc_data($id)
    {
        $nc_data = [];

        $preference = NCPreference::where('contact_id', $id)->first();
        $medical = DB::table('vlife_medical')->where('contact_id', $id)->get();
        $critical_illness = DB::Table('vlife_critical_illness')->where('contact_id', $id)->get();
        $death_tpd = DB::Table('vlife_death_tpd')->where('contact_id', $id)->get();

        $nc_data = [
            'preference' => $preference,
            'medical' => $medical,
            'critical_illness' => $critical_illness,
            'death_tpd' => $death_tpd,
        ];

        return \Response::json($nc_data);
    }

    public function save_nc(Request $request)
    {
        $post = $request->input();
        $contact_id = $post['contact_id'];
        $nc_data = $post['nc_data'];
        NCPreference::updateOrInsert(['contact_id' => $contact_id], $nc_data['preference']);

        $this->save_nc_by_type(NCMedical::class, $nc_data['medical'], $contact_id);
        $this->save_nc_by_type(NCCriticalIllness::class, $nc_data['critical_illness'], $contact_id);
        $this->save_nc_by_type(NCDeathTpd::class, $nc_data['death_tpd'], $contact_id);
    }

    private function save_nc_by_type($class, $data, $contact_id)
    {
        foreach ($data as $d) {
            $id = $d['id'] ?? null;
            $is_delete = $d['deleted'] ?? false;

            //create
            if ($id == null && !$is_delete) {
                $d['contact_id'] = $contact_id;
                $class::create($d);
            } else {
                if ($id != null) {
                    if ($is_delete) {
                        $class::find($id)->delete();
                    } else {
                        $class::find($id)->fill($d)->save();
                    }
                }
            }
        }
    }

    public function get_nc_industry_recommendation(Request $request, $contact_id)
    {
        $contact_id = $request->input('contact_id') ?? $contact_id;

        $annual_income = get_contact_annual_income($contact_id);
        $category = DB::Table('vlife_maintenance_nc_type_category')->get();

        $industry_recommendation = [];
        foreach ($category as $d) {
            if ($d->use_annual_income == 1) {
                $industry_recommendation[$d->category_code] = $annual_income * $d->multiply_annual_income;
            } else {
                $industry_recommendation[$d->category_code] = $d->amount_prefered;
            }
        }
        return $industry_recommendation;
    }

    public function get_nc_industry_recommendation_distribution(Request $request)
    {
        $total_amount = $request->input('total');
        $category = $request->input('category');

        $items = DB::Table('vlife_maintenance_nc_type_data')->where('category', $category)->get();
        $result = [];
        foreach ($items as $i) {
            $amount = 0;

            if ($i->percentage_prefered > 0) {
                $amount = $total_amount * $i->percentage_prefered / 100;
            } else {
                $amount = $i->amount_prefered;
            }

            $result[] = [
                'category' => $i->category,
                'type' => $i->type_code,
                'description' => $i->type_name,
                'total_amount' => $amount
            ];
        }
        return $result;
    }
}
