<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;

//MODEL TO USE
use App\Models\Contacts;
use App\Models\Contacts\Achievement;
use App\Models\Contacts\Company;
use App\Models\Contacts\Education;
use App\Models\Contacts\Family;
use App\Models\Contacts\Health;
use App\Models\Contacts\Preference;
use App\Models\Contacts\ValuesBeliefs;
use App\Models\Contacts\Address;
use App\Models\Contacts\Notes;
//insurance
use App\Models\Insurance;
use App\Models\Insurance\Coverage as InsuranceCoverage;
use App\Models\Insurance\ProjectedBenefit as InsuranceProjectedBenefit;
use App\Classes\Lists;
use App\Classes\VueTable;

class VLifeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('vlife_index');
    }

    public function myContact(Request $request)
    {
        return view('vlife_index')->with('request', $request);
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
                if (!isset($deleted_data['id'])) continue;

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
            'Quarterly' => 'Quarterly',
            'Half Yearly' => 'Half Yearly',
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
        $income_data = DB::table('vlife_asset_investment')->where('status', 1)->where('id', $id)->first();

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


    /* *****
        *
        Insurance Start
        *
    *****/
    public function getInsurance(Request $request, $id)
    {
        $insurance_type = $request->insurance_type;
        $data = Insurance::from('vlife_contacts_insurance AS i');
        $data->where('contact_id', $id);
        $data->selectRaw('
            i.*,
            SUM( DISTINCT
                IF(vic.coverage_type IN ("Death","TPD"),
                    vic.sum_assured,
                    0
                )
            ) AS sum_death_tpd,
            SUM( DISTINCT
                IF(vic.coverage_type IN ("Critical Illnesses"),
                    vic.sum_assured,
                    0
                )
            ) AS sum_critical_illness,
            0 AS sum_accidental_death_tpd
        ');
        if ($insurance_type == 'total_benefit') {
            $data->where('incl', 1);
        } else if ($insurance_type != null) {
            $data->where('insurance_type', $insurance_type);
        }

        $data->leftJoin('vlife_contacts_insurance_coverage AS vic', 'vic.insurance_id', '=', 'i.id');
        $data->groupBy('i.id');

        $data = VueTable::fetch($data, $request, []);

        return $data;
    }

    public function get_insurance_dropdown(Request $request)
    {
        return [
            'coverage_frequency' => Lists::coverage_frequency(),
            'coverage_type' => Lists::coverage_type(),
            'insurance_assured' => Lists::insurance_assured(),
            'insurance_plan_type' => Lists::insurance_plan_type(),
            'premium_frequency' => Lists::premium_frequency(),
            'premium_status' => Lists::premium_status(),
            'relationship' => Lists::relationship(),
        ];
    }

    public function getInsuranceDetail(Request $request, $id)
    {
        $data = Insurance::where('id', $id);
        $data->with(['coverage', 'projected_benefit']);
        $data = $data->first();
        return $data;
    }
    public function saveInsurance(Request $request)
    {
        $form = $request->input('form');

        $is_create = $form['is_create'] ?? false;
        if ($is_create) {
            $insurance = Insurance::create($form);
            foreach ($form['coverage'] as $coverage) {
                $coverage = new InsuranceCoverage($coverage);
                $insurance->coverage()->save($coverage);
            }
            foreach ($form['projected_benefit'] as $projected_benefit) {
                $projected_benefit = new InsuranceProjectedBenefit($projected_benefit);
                $insurance->projected_benefit()->save($projected_benefit);
            }
            return $insurance;
        } else {
            //UPDATE
            Insurance::find($form['id'])->fill($form)->save();
            $insurance = Insurance::find($form['id']);

            $projected_benefit = $form['projected_benefit'];
            foreach ($form['coverage'] as $coverage) {
                $coverage_id = $coverage['id'] ?? null;

                if ($coverage_id != null) {
                    $deleted = $coverage['deleted'] ?? false;
                    if ($deleted) {
                        InsuranceCoverage::find($coverage_id)->delete();
                    } else {
                        InsuranceCoverage::find($coverage_id)->fill($coverage)->save();
                    }
                } else {
                    $coverage = new InsuranceCoverage($coverage);
                    $insurance->coverage()->save($coverage);
                }
            }
        }
    }

    public function updateIncludeCalculationStatus(Request $request)
    {
        $post = $request->input();
        $insurance_id = $post['insurance_id'];
        $status = $post['status'];
        Insurance::find($insurance_id)->fill(['incl' => $status])->save();
    }

    public function deleteInsurance(Request $request)
    {
        $post = $request->input();
        $insurance_id = $post['insurance_id'];
        Insurance::find($insurance_id)->delete();
        InsuranceProjectedBenefit::where('insurance_id', $insurance_id)->delete();
        InsuranceCoverage::where('insurance_id', $insurance_id)->delete();
    }
    public function updateInsuranceToExisting(Request $request)
    {
        $post = $request->input();
        $insurance_id = $post['insurance_id'];
        Insurance::find($insurance_id)->fill(['insurance_type' => 'existing'])->save();
    }
}
