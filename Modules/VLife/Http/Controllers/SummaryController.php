<?php

namespace Modules\VLife\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;

//MODEL TO USE
use Modules\VLife\Entities\Contacts;
//insurance
use Modules\VLife\Entities\Insurance;
use Modules\VLife\Entities\Insurance\Coverage as InsuranceCoverage;
use Modules\VLife\Entities\Insurance\ProjectedBenefit as InsuranceProjectedBenefit;
use Modules\VLife\Classes\Lists;
use Modules\VLife\Classes\VueTable;

class SummaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_recommendation(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $data = Insurance::from('vlife_insurance AS i');
        $data->where('contact_id', $contact_id);
        $data->where('insurance_type', 'recommendation');
        $data->leftJoin('vlife_insurance_coverage AS vic', 'vic.insurance_id', '=', 'i.id');
        $data->selectRaw('
            i.*,
            SUM( DISTINCT
                IF(vic.coverage_type IN ("Death","TPD"),
                    vic.sum_assured,
                    0
                )
            ) AS sum_death_tpd,
            SUM( DISTINCT
                IF(vic.coverage_type IN ("Critical Illesses"),
                    vic.sum_assured,
                    0
                )
            ) AS sum_critical_illness,
            0 AS sum_accidental_death_tpd
        ');
        $data = $data->get();
        return $data;
    }

    public function get_income_by_type(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $data = DB::table('vlife_cashflow AS vc');
        $data->selectRaw('
            type,
            SUM( IF( frequency="Monthly", amount*12, amount)) AS amount
        ');
        $data->groupBy('type');
        $data->where('contact_id', $contact_id);
        $data->where('incl', 1);
        $data->where('status', 1);
        $data = $data->get();

        $arr = [
            'Gross Income' => [
                'color' => '#2962FF',
                'amount' => 0,
            ],
            'Bonus' => [
                'color' => '#FF4081',
                'amount' => 0,
            ],
            'Dividend' => [
                'color' => '#64DD17',
                'amount' => 0,
            ],
            'Rental' => [
                'color' => '#FDD835',
                'amount' => 0,
            ],
        ];

        foreach ($data as $d) {
            $type = $d->type;
            $arr[$type]['amount'] = $d->amount;
        }

        return $arr;
    }

    public function get_assets_investment_by_type(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $data = DB::table('vlife_asset_investment AS vai');
        $data->selectRaw('
            type,
            current_value AS amount
        ');
        $data->groupBy('type');
        $data->where('contact_id', $contact_id);
        $data->where('incl', 1);
        $data->where('status', 1);
        $data = $data->get();

        $arr = [
            'Property' => [
                'color' => '#FF4081',
                'amount' => 0,
            ],
            'EPF' => [
                'color' => '#F57F17',
                'amount' => 0,
            ],
            'Unit Trust' => [
                'color' => '#FFD54F',
                'amount' => 0,
            ],
            'Saving' => [
                'color' => '#00E676',
                'amount' => 0,
            ],
            'Insurance' => [
                'color' => '#2979FF',
                'amount' => 0,
            ],
            'Private Equity' => [
                'color' => '#D500F9',
                'amount' => 0,
            ],
        ];

        foreach ($data as $d) {
            $type = $d->type;
            $arr[$type]['amount'] = $d->amount;
        }

        return $arr;
    }

    public function get_insurance_policy_summary(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $contact = Contacts::find($contact_id);
        $age = $contact->age;

        $data = DB::Table('vlife_insurance AS vi');
        $data->selectRaw('vic.*');
        $data->where('contact_id', $contact_id);
        $data->leftJoin('vlife_insurance_coverage AS vic', 'vi.id', '=', 'vic.insurance_id');
        $data = $data->get();

        //with age
        $result = [
            'Accidental' => [
                'color' => '#5D4037',
                'title' => 'Accidental',
                'items' => [],
            ],
            'Medical' => [
                'color' => '#2979FF',
                'title' => 'Medical',
                'items' => [],
            ],
            'Death' => [
                'color' => '#FF4081',
                'title' => 'Death',
                'items' => [],
            ],
            'TPD' => [
                'color' => '#006064',
                'title' => 'TPD',
                'items' => [],
            ],
            'Critical Illesses' => [
                'color' => '#00E676',
                'title' => 'CI',
                'items' => [],
            ],
            'Early CI' => [
                'color' => '#00E5FF',
                'title' => 'Early CI',
                'items' => [],
            ],
            'Others' => [
                'color' => '#F57F17',
                'title' => 'Others',
                'items' => [],
            ],

        ];

        $count_age = $age;
        while ($count_age < 100) {
            foreach ($data as $d) {
                $age_from = $d->coverage_age_from;
                $age_to = $d->coverage_age_to;
                $type = $d->coverage_type;

                foreach ($result as $key => $v) {
                    if (!isset($result[$key]['items'][$count_age])) {
                        $result[$key]['items'][$count_age] = [
                            'amount' => 0
                        ];
                    }

                    if ($key == $type && $count_age >= $age_from && $count_age <= $age_to) {
                        $result[$key]['items'][$count_age]['amount'] += $d->sum_assured;
                    }
                }
            }
            $count_age += 1;
        }

        return $result;
    }

    public function get_insurance_policy_premium(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $contact = Contacts::find($contact_id);
        $age = $contact->age;

        $data = DB::Table('vlife_insurance AS vi');
        $data->where('contact_id', $contact_id);
        $data->where('incl', 1);
        $data = $data->get();

        //with age
        $result = [
            'Premium' => [
                'color' => '#FF4081',
                'title' => 'Premium',
                'items' => [],
            ],
        ];

        $count_age = $age;
        while ($count_age < 100) {
            foreach ($data as $d) {
                $age_from = $d->premium_start_age;
                $age_to = $d->premium_maturity_age;
                $type = 'Premium';

                foreach ($result as $key => $v) {
                    if (!isset($result[$key]['items'][$count_age])) {
                        $result[$key]['items'][$count_age] = [
                            'amount' => 0
                        ];
                    }

                    if ($key == $type && $count_age >= $age_from && $count_age <= $age_to) {
                        $result[$key]['items'][$count_age]['amount'] += $d->premium_amount;
                    }
                }
            }
            $count_age += 1;
        }

        return $result;
    }

    public function get_assurance_needs(Request $request)
    {
        $contact_id = $request->input('contact_id');

        //medical need
        $medical_need = DB::Table('vlife_medical');
        $medical_need->selectRaw('
            "vlife_medical" AS model_table,
            id AS model_id,
            "medical" AS category,
            "need" AS need_have,
            type AS type,
            description AS description,
            total_amount AS amount
        ');
        $medical_need->where('contact_id', $contact_id);
        $medical_need = $medical_need->get()->toArray();
        //medical have
        $medical_have = DB::Table('vlife_insurance');
        $medical_have->selectRaw('
            "vlife_insurance" AS model_table,
            id AS model_id,
            "medical" AS category,
            "have" AS need_have,
            "insurance" AS type,
            policy_no AS description,
            medical_benefit_annual_limit AS amount
        ');
        $medical_have->where('contact_id', $contact_id);
        $medical_have->where('incl', 1);
        $medical_have = $medical_have->get()->toArray();

        //ci need
        $ci_need = DB::Table('vlife_critical_illness');
        $ci_need->where('contact_id', $contact_id);
        $ci_need = $ci_need->get();
        //ci have
        $ci_have = DB::Table('vlife_insurance AS vi');
        $ci_have->leftJoin('vlife_insurance_coverage AS vic', 'vic.insurance_id', '=', 'vi.id');
        $ci_have->where('coverage_type', 'Critical Illesses');
        $ci_have->where('contact_id', $contact_id);
        $ci_have->where('incl', 1);
        $ci_have = $ci_have->get();

        //death need
        $death_need = DB::Table('vlife_death_tpd_2');
        $death_need->where('contact_id', $contact_id);
        $death_need = $death_need->get();
        //death have
        $death_have = DB::Table('vlife_insurance AS vi');
        $death_have->leftJoin('vlife_insurance_coverage AS vic', 'vic.insurance_id', '=', 'vi.id');
        $death_have->where('coverage_type', 'Death');
        $death_have->where('contact_id', $contact_id);
        $death_have->where('incl', 1);
        $death_have = $death_have->get();

        $data = array_merge($medical_need, $medical_have);
        return $data;
        foreach ($medical_have as $d) {
        }

        //init data structure, for ease in understanding
        $data = [
            'medical' => [
                'title' => 'MEDICAL',
                'total_need' => 0,
                'total_have' => 0,
                'need' => [
                    'personal_medical' => [
                        'title' => 'Personal Medical',
                        'total' => 0,
                        'items' => []
                    ]
                ],
                'have' => [
                    'insurance' => [
                        'title' => 'Insurance',
                        'total' => 0,
                        'items' => []
                    ]
                ]
            ],
            'ci' => [
                'title' => 'CRITICAL ILLNESS',
                'total_need' => 0,
                'total_have' => 0,
                'need' => [],
                'have' => []
            ],
            'death' => [
                'title' => 'DEATH / TPD',
                'total_need' => 0,
                'total_have' => 0,
                'need' => [],
                'have' => []
            ]
        ];

        //start medical
        foreach ($medical_need as $d) {
            $item = [
                'description' => $d->description,
                'amount' => $d->total_amount,
                'percentage' => 100
            ];
            $data['medical']['total_need'] += $d->total_amount;
            $data['medical']['need']['personal_medical']['items'][] = $item;
        }
        foreach ($medical_have as $d) {
            $item = [
                'description' => $d->policy_no,
                'amount' => $d->medical_benefit_lifetime_limit,
                'percentage' => 100

            ];
            $data['medical']['total_have'] += $d->medical_benefit_lifetime_limit;
            $data['medical']['have']['insurance']['items'][] = $item;
        }
        //end medical
        /*
        //start ci
        foreach ($ci_need as $d) {
            $item = [
                'description' => $d->description,
                'total_amount' => $d->total_amount
            ];
            $data['ci']['total_need'] += $d->total_amount;
            $data['ci']['need'][] = $item;
        }
        foreach ($ci_have as $d) {
            $item = [
                'description' => $d->policy_no,
                'total_amount' => $d->sum_assured
            ];
            $data['ci']['total_have'] += $d->sum_assured;
            $data['ci']['have'][] = $item;
        }
        //end ci

        //start death
        foreach ($death_need as $d) {
            $item = [
                'description' => $d->description,
                'total_amount' => $d->total_amount
            ];
            $data['death']['total_need'] += $d->total_amount;
            $data['death']['need'][] = $item;
        }
        foreach ($death_have as $d) {
            $item = [
                'description' => $d->policy_no,
                'total_amount' => $d->sum_assured
            ];
            $data['death']['total_have'] += $d->sum_assured;
            $data['death']['have'][] = $item;
        }
        //end death
        */



        return $data;
    }
}
