<?php

namespace Modules\VLife\Entities\Insurance;

use Illuminate\Database\Eloquent\Model;

class ProjectedBenefit extends Model
{
    protected $table = "vlife_insurance_projected_benefits";
    protected $fillable = [
        'insurance_id',
        'projected_value',
        'frequency',
        'age_from',
        'age_to',

    ];
    public $timestamps = false;

    public static function createRules($alias)
    {
        return [
            'insurance_id' => '',
            'projected_value' => '',
            'frequency' => '',
            'age_from' => '',
            'age_to' => ''
        ];
    }
    public static function updateRules($id)
    {
        $updateRules = ProjectedBenefit::createRules();
        return $updateRules;
    }

    public function insurance()
    {
        return $this->belongTo('Modules\VLife\Entities\Insurance', 'insurance_id');
    }
}
