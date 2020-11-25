<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Traits\ModelObservantTrait;

class ServicePlan extends Model
{
    use ModelObservantTrait;
    protected $table='service_plan';
    protected $guarded=['id'];
    public $timestamps = false;
}
