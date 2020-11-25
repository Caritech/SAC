<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Traits\ModelObservantTrait;

class BudgetPlanItemCost extends Model
{
    use ModelObservantTrait;
    protected $table='budget_plan_breakdown_item';
    protected $guarded=['id'];
    public $timestamps = false;
}
