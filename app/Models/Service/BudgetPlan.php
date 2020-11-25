<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Traits\ModelObservantTrait;

class BudgetPlan extends Model
{
    use ModelObservantTrait;
    protected $table='budget_plan';
    protected $guarded=['id'];
    public $timestamps = false;
}
