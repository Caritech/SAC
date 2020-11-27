<?php

namespace Modules\VLife\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;

//MODEL TO USE
use Modules\VLife\Entities\Contacts;
use Modules\VLife\Entities\Contacts\Achievement;
use Modules\VLife\Entities\Contacts\Company;
use Modules\VLife\Entities\Contacts\Education;
use Modules\VLife\Entities\Contacts\Family;
use Modules\VLife\Entities\Contacts\Health;
use Modules\VLife\Entities\Contacts\Preference;
use Modules\VLife\Entities\Contacts\ValuesBeliefs;
use Modules\VLife\Entities\Contacts\Address;
use Modules\VLife\Entities\Contacts\Notes;

class VLifeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('vlife::index');
    }

    public function myContact(Request $request)
    {
        return view('vlife::my_contact')->with('request', $request);
    }

    public function getContactProfileData($contact_id)
    {
        // $vlife_contacts = DB::table('vlife_contacts')->where('id', $contact_id)->first();
        // $vlife_contacts->json_fields = json_decode($vlife_contacts->json_fields, true);
        // return \Response::json($vlife_contacts);
        $data = Contacts::where('vlife_contacts.id', $contact_id);
        $data->with(['preference', 'valuesBeliefs', 'achievement', 'education', 'family', 'address', 'health', 'company', 'notes']);
        $data->leftJoin('vlife_nationality AS nation', 'nation.id', '=', 'vlife_contacts.nationality_id');
        $data->leftJoin('vlife_country AS country', 'country.id', '=', 'vlife_contacts.birth_country_id');
        $data->selectRaw('
        vlife_contacts.*,
        nation.name AS nationality_name,
        country.name AS birth_country_name
        ');
        $data = $data->first()->toArray();

        $data['preference'] = db_json_decode($data['preference']);
        $data['values_beliefs'] = db_json_decode($data['values_beliefs']);
        $data['achievement'] = db_json_decode($data['achievement']);
        $data['notes'] = db_json_decode($data['notes']);

        //json field decode
        if ($data['health'] != null) {
            $data['health']['medical_condition'] =  json_decode($data['health']['medical_condition'] ?? []);
            $data['health']['medical_history'] =  json_decode($data['health']['medical_history'] ?? []);
        }
        if ($data['education'] != null) {
            $data['education']['other_qualification'] =  json_decode($data['education']['other_qualification'] ?? []);
            $data['education']['education_type'] =  json_decode($data['education']['education_type'] ?? []);
        }
        if ($data['family'] != null) {
            $data['family']['spouse'] =  json_decode($data['family']['spouse'] ?? []);
            $data['family']['child'] =  json_decode($data['family']['child'] ?? []);
            $data['family']['sibling'] =  json_decode($data['family']['sibling'] ?? []);
            $data['family']['parent'] =  json_decode($data['family']['parent'] ?? []);
        }


        return $data;
    }

    public function saveContactProfile(Request $request)
    {
        $data = $request->input();
        unset($data['_token']);

        $data = $data['contact_data'];

        if (isset($data['id'])) {
            $id = $data['id'];

            unset($data['id']);
            unset($data['contact_id']);

            $data = add_update_dt_user($data);

            //$data['json_fiexlds'] = json_encode($data['json_fields']);
            //dd($data);
            Contacts::find($id)->fill($data)->save();

            //save address
            foreach ($data['address'] as $address) {
                $address_id = $address['id'] ?? null;
                if ($address_id == null) {
                    $address = new Address($address);
                    Contacts::find($id)->address()->save($address);
                } else {
                    Address::find($address_id)->fill($address)->save();
                }
            }

            //save companu
            foreach ($data['company'] as $company) {
                $company_id = $company['id'] ?? null;
                if ($company_id == null) {
                    $company = new Company($company);
                    Contacts::find($id)->company()->save($company);
                } else {
                    Company::find($company_id)->fill($company)->save();
                }
            }

            foreach ($data['deleted_data'] as $deleted_data) {
                if ($deleted_data['name'] == 'address') {
                    Address::find($deleted_data['id'])->delete();
                } elseif ($deleted_data['name'] == 'company') {
                    Company::find($deleted_data['id'])->delete();
                }
            }

            Preference::updateOrCreate(
                ['contact_id' => $id],
                db_json_encode($data['preference'] ?? [])
            );

            Health::updateOrCreate(
                ['contact_id' => $id],
                [
                    'height' => $data['health']['height'] ?? null,
                    'weight' => $data['health']['weight'] ?? null,
                    'smoker' => $data['health']['smoker'] ?? null,
                    'medical_condition' => json_encode($data['health']['medical_condition'] ?? []),
                    'medical_history' => json_encode($data['health']['medical_history'] ?? []),
                ]
            );
            ValuesBeliefs::updateOrCreate(
                ['contact_id' => $id],
                db_json_encode($data['values_beliefs'] ?? [])
            );
            Achievement::updateOrCreate(
                ['contact_id' => $id],
                db_json_encode($data['achievement'] ?? [])
            );
            Education::updateOrCreate(
                ['contact_id' => $id],
                [
                    'education_level' => $data['education']['education_level'] ?? null,
                    'other_qualification' => json_encode($data['education']['other_qualification'] ?? []),
                    'education_type' => json_encode($data['education']['education_type'] ?? []),
                ]
            );
            Family::updateOrCreate(
                ['contact_id' => $id],
                [
                    'anniversary_date' => $data['family']['anniversary_date'] ?? null,
                    'spouse' => json_encode($data['family']['spouse'] ?? []),
                    'child' => json_encode($data['family']['child'] ?? []),
                    'sibling' => json_encode($data['family']['sibling'] ?? []),
                    'parent' => json_encode($data['family']['parent'] ?? []),
                ]
            );
            Notes::updateOrCreate(
                ['contact_id' => $id],
                db_json_encode($data['notes'] ?? [])
            );
        } else {
            $data = add_create_dt_user($data);
            $id = DB::table('vlife_contacts')->insertGetId($data);
        }

        return \Response::json($id);
    }
    public function inactiveContactProfile(Request $request)
    {
        $response = [];
        $id = $request->input('id');
        if (isset($id) && $id != "") {
            Contacts::where('id', $id)->update(['status' => 0]);
            $response['title'] = 'Success';
            $response['status']  = 'success';
            $response['message'] = 'Contact profile have been inactive successfully!';
        } else {
            $response['title'] = 'Error';
            $response['status']  = 'error';
            $response['message'] = 'Unable to inactive the contact profile!';
        }
        return json_encode($response);
    }

    public function inactiveCashflowIncome(Request $request)
    {
        $response = [];
        $id = $request->input('id');
        if (isset($id) && $id != "") {
            DB::table('vlife_cashflow')->where('id', $id)->update(['status' => 0]);
            $response['title'] = 'Success';
            $response['status']  = 'success';
            $response['message'] = 'Cashflow record have been inactive successfully!';
        } else {
            $response['title'] = 'Error';
            $response['status']  = 'error';
            $response['message'] = 'Unable to inactive the cashflow record!';
        }
        return json_encode($response);
    }

    public function updateCashflowInclStatus(Request $request)
    {
        $response = [];
        $id = $request->input('id');

        if (isset($id) && $id != "") {
            $cashflow_data =  DB::table('vlife_cashflow')->where('id', $id)->first();
            if ($cashflow_data->incl == 1) {
                DB::table('vlife_cashflow')->where('id', $id)->update(['incl' => 0]);
            } else {
                DB::table('vlife_cashflow')->where('id', $id)->update(['incl' => 1]);
            }
            $response['title'] = 'Success';
            $response['status']  = 'success';
            $response['message'] = 'Incl status have been updated successfully!';
        } else {
            $response['title'] = 'Error';
            $response['status']  = 'error';
            $response['message'] = 'Unable to update incl status!';
        }
        return json_encode($response);
    }


    public function saveCashflowIncome(Request $request)
    {
        $data = $request->input();
        unset($data['_token']);

        $data = $data['income_data'];
        $data['amount'] = (int) filter_var($data['amount'], FILTER_SANITIZE_NUMBER_INT);
        $contact_id = $data['contact_id'];

        if (isset($data['id'])) {
            $id = $data['id'];

            unset($data['id']);
            unset($data['contact_id']);

            $data = add_update_dt_user($data);
            DB::table('vlife_cashflow')->where('id', $id)->update($data);
        } else {
            $data = add_create_dt_user($data);
            DB::table('vlife_cashflow')->insert($data);
        }

        return \Response::json($contact_id);
    }

    /* Get data for axios */
    public function getContactList(Request $request)
    {
        $sort = $request->input('sort') ?? null;
        $page = $request->input('page') ?? null;
        $per_page = $request->input('per_page') ?? null;

        $vlife_contacts = DB::table('vlife_contacts')->where('status', 1);

        if (isset($request->search)) {
            $vlife_contacts->where('name', 'like', '%' . trim($request->search) . '%');
        }

        $vlife_contacts = $vlife_contacts->paginate(10);

        return \Response::json($vlife_contacts);
    }

    public function getContactCashflowIncome(Request $request)
    {
        $sort = $request->input('sort') ?? null;
        $page = $request->input('page') ?? null;
        $per_page = $request->input('per_page') ?? null;

        $vlife_cashflow = DB::table('vlife_cashflow')->where('status', 1)->where('contact_id', $request->id);

        if (isset($request->search)) {
            $vlife_cashflow->where('description', 'like', '%' . trim($request->search) . '%');
        }

        $vlife_cashflow = $vlife_cashflow->paginate(10);

        return \Response::json($vlife_cashflow);
    }

    public function getContactCashflowIncomeOption()
    {
        $type_options = [
            'Gross Income' => 'Gross Income',
            'Bonus' => 'Bonus',
            'Dividend' => 'Dividend',
            'Rental' => 'Rental'
        ];

        $frequency_options = [
            'Monthly' => 'Monthly',
            'Yearly' => 'Yearly'
        ];

        $yesno_options = ['N' => 'No', 'Y' => 'Yes'];

        $options = [
            'type_options' => array_to_js_array($type_options),
            'frequency_options' => array_to_js_array($frequency_options),
            'yesno_options' => array_to_js_array($yesno_options)
        ];

        return $options;
    }

    public function getContactCashflowIncomeData($id)
    {
        $income_data = DB::table('vlife_cashflow')->where('id', $id)->first();

        return \Response::json($income_data);
    }
    public function getContactCashflowIncomeDataTest()
    {
        $income_data = DB::table('vlife_cashflow')->selectRaw('*, CEILING(amount) as round_off_amount')->where('id', 1)->first();

        return \Response::json($income_data);
    }


    public function getContactAssetInvestment(Request $request)
    {
        $sort = $request->input('sort') ?? null;
        $page = $request->input('page') ?? null;
        $per_page = $request->input('per_page') ?? null;

        $vlife_asset_investment = DB::table('vlife_asset_investment')->where('contact_id', $request->id)->where('status', 1);

        if (isset($request->search)) {
            $vlife_asset_investment->where('description', 'like', '%' . trim($request->search) . '%');
        }

        $vlife_asset_investment = $vlife_asset_investment->paginate(10);

        return \Response::json($vlife_asset_investment);
    }

    public function getContactAssetInvestmentOption()
    {
        $type_options = [
            'Property' => 'Property',
            'EPF' => 'EPF',
            'Unit Trust' => 'Unit Trust',
            'Saving' => 'Saving',
            'Private Equity' => 'Private Equity'
        ];

        $options = [
            'type_options' => array_to_js_array($type_options),
        ];

        return $options;
    }

    public function getContactAssetInvestmentData($id)
    {
        $income_data = DB::table('vlife_asset_investment')->where('id', $id)->first();

        return \Response::json($income_data);
    }
    public function inactiveAssetInvestment(Request $request)
    {
        $response = [];
        $id = $request->input('id');
        if (isset($id) && $id != "") {
            DB::table('vlife_asset_investment')->where('id', $id)->update(['status' => 0]);
            $response['title'] = 'Success';
            $response['status']  = 'success';
            $response['message'] = 'Asset & Investment record have been inactive successfully!';
        } else {
            $response['title'] = 'Error';
            $response['status']  = 'error';
            $response['message'] = 'Unable to inactive the asset & investment record!';
        }
        return json_encode($response);
    }

    public function updateAssetInvestmentStatus(Request $request)
    {
        $response = [];
        $id = $request->input('id');

        if (isset($id) && $id != "") {
            $asset_investment_data =  DB::table('vlife_asset_investment')->where('id', $id)->first();
            if ($asset_investment_data->incl == 1) {
                DB::table('vlife_asset_investment')->where('id', $id)->update(['incl' => 0]);
            } else {
                DB::table('vlife_asset_investment')->where('id', $id)->update(['incl' => 1]);
            }
            $response['title'] = 'Success';
            $response['status']  = 'success';
            $response['message'] = 'Incl status have been updated successfully!';
        } else {
            $response['title'] = 'Error';
            $response['status']  = 'error';
            $response['message'] = 'Unable to update incl status!';
        }
        return json_encode($response);
    }

    public function saveAssetInvestment(Request $request)
    {
        $data = $request->input();
        unset($data['_token']);

        $data = $data['asset_investment_data'];
        $data['current_value'] = (int) filter_var($data['current_value'], FILTER_SANITIZE_NUMBER_INT);
        $contact_id = $data['contact_id'];

        if (isset($data['id'])) {
            $id = $data['id'];

            unset($data['id']);
            unset($data['contact_id']);

            $data = add_update_dt_user($data);
            DB::table('vlife_asset_investment')->where('id', $id)->update($data);
        } else {
            $data = add_create_dt_user($data);
            DB::table('vlife_asset_investment')->insert($data);
        }

        return \Response::json($contact_id);
    }

    public function getNationalityOption()
    {
        $nationality = DB::table('vlife_nationality')->pluck('name', 'id');
        return \Response::json(array_to_js_array($nationality));
    }

    public function getCountryOption()
    {
        $country = DB::table('vlife_country')->pluck('name', 'id');
        return \Response::json(array_to_js_array($country));
    }

    public function getStateOption()
    {
        $state = DB::table('vlife_state')->get();
        $state_lists = [];
        foreach ($state as $s) {
            $state_lists[$s->country_id][] = [
                'value' => $s->id,
                'text' => $s->name

            ];
        }
        return \Response::json($state_lists);
        //fddgit
    }
    public function getNCData($id)
    {
        $nc_data = [];
        $nc_data['medical']['personal_medicals'] = DB::table('vlife_medical')->where('contact_id', $id)->where('type', 'personal_medical')->get();

        return \Response::json($nc_data);
    }
    public function saveNCMedical(Request $request)
    {
        $data = $request->input();
        unset($data['_token']);

        $personal_medicals = $data['personal_medicals'];
        $contact_id = $data['contact_id'];
        foreach ($personal_medicals as $key => $personal_medical) {
            if (isset($personal_medical['id'])) {
                $id = $personal_medical['id'];
                unset($personal_medical['id']);
                unset($personal_medical['contact_id']);
                $personal_medical = add_update_dt_user($personal_medical);
                DB::table('vlife_medical')->where('id', $id)->update($personal_medical);
            } else {
                $personal_medical['type'] = 'personal_medical';
                $personal_medical['contact_id'] = $contact_id;
                $personal_medical = add_create_dt_user($personal_medical);
                DB::table('vlife_medical')->insert($personal_medical);
            }
        }

        return \Response::json($contact_id);
    }
}
