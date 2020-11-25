<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Traits\ModelObservantTrait;

class ServiceAgreement extends Model
{
    use ModelObservantTrait;
    protected $table='service_agreement';
    protected $guarded=['id'];
    public $timestamps = false;
}
