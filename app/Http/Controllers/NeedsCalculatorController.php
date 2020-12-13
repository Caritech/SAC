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

            //create
            if ($id == null) {
                $d['contact_id'] = $contact_id;
                $class::create($d);
            } else {
                $is_delete = $d['deleted'] ?? false;
                if ($is_delete) {
                    $class::find($id)->delete();
                } else {
                    $class::find($id)->fill($d)->save();
                }
            }
        }
    }
}
