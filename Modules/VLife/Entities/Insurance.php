<?php

namespace Modules\VLife\Entities;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $table = "vlife_insurance";
    protected $fillable = [
        'contact_id',
        'insurance_type',
        'incl',
        'insurer',
        'policy_no',
        'recommendation_no',
        'life_assured',
        'plan_name',
        'start_date',
        'maturity_date',
        'start_age',
        'maturity_age',
        'plan_type',
        'premium_amount',
        'premium_status',
        'premium_frequency_increment',
        'premium_start_date',
        'premium_maturity_date',
        'premium_start_age',
        'premium_maturity_age',
        'nomination_name',
        'nomination_relationship',
        'nomination_percentage',
        'comment',
        'chk_medical_benefit',
        'medical_benefit_room_board_rate',
        'medical_benefit_annual_limit',
        'medical_benefit_lifetime_limit',
        'medical_benefit_co_insurance',
        'medical_benefit_start_date',
        'medical_benefit_maturity_date',
        'medical_benefit_start_age',
        'medical_benefit_maturity_age',
        'medical_benefit_remarks',
    ];
    public $timestamps = false;

    public static function createRules($alias)
    {
        return [
            'insurance_type' => '',
            'incl' => '',
            'insurer' => '',
            'policy_no' => '',
            'recommendation_no' => '',
            'life_assured' => '',
            'plan_name' => '',
            'start_date' => '',
            'maturity_date' => '',
            'start_age' => '',
            'maturity_age' => '',
            'plan_type' => '',
            'premium_amount' => '',
            'premium_status' => '',
            'premium_frequency_increment' => '',
            'premium_start_date' => '',
            'premium_maturity_date' => '',
            'premium_start_age' => '',
            'premium_maturity_age' => '',
            'nomination_name' => '',
            'nomination_relationship' => '',
            'nomination_percentage' => '',
            'comment' => '',
            'chk_medical_benefit' => '',
            'medical_benefit_room_board_rate' => '',
            'medical_benefit_annual_limit' => '',
            'medical_benefit_lifetime_limit' => '',
            'medical_benefit_co_insurance' => '',
            'medical_benefit_start_date' => '',
            'medical_benefit_maturity_date' => '',
            'medical_benefit_start_age' => '',
            'medical_benefit_maturity_age' => '',
            'medical_benefit_remarks' => '',
        ];
    }
    public static function updateRules($id)
    {
        $updateRules = Insurance::createRules();
        return $updateRules;
    }

    public function coverage()
    {
        return $this->hasMany('Modules\VLife\Entities\Insurance\Coverage', 'insurance_id');
    }

    public function projected_benefit()
    {
        return $this->hasMany('Modules\VLife\Entities\Insurance\ProjectedBenefit', 'insurance_id');
    }
}
