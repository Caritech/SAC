<?php

namespace App\Models\Insurance;

use Illuminate\Database\Eloquent\Model;

class Coverage extends Model
{
    protected $table = "vlife_contacts_insurance";
    protected $fillable = [
        'insurance_id',
        'coverage_type',
        'coverage_age_from',
        'coverage_age_to',
        'frequency',
        'sum_assured',

    ];
    public $timestamps = false;

    public static function createRules($alias)
    {
        return [
            'insurance_id' => '',
            'coverage_type' => '',
            'coverage_age_from' => '',
            'coverage_age_to' => '',
            'frequency' => '',
            'sum_assured' => '',
        ];
    }
    public static function updateRules($id)
    {
        $updateRules = Coverage::createRules();
        return $updateRules;
    }

    public function insurance()
    {
        return $this->belongTo('App\Models\Insurance', 'insurance_id');
    }
}
