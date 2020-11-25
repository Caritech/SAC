<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Traits\ModelObservantTrait;

class ServiceAssignment extends Model
{
    use ModelObservantTrait;
    protected $table='service_assignment';
    protected $guarded=['id'];
    public $timestamps = false;
}
