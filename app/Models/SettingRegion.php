<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingRegion extends Model
{
    protected $table = "setting_region";

    protected $fillable = [
        'Region','RegionName', 'Dom', 'Res', 'Soc', 'CBDC', 'CSIA', 'Assess', 'Trans', 'DLRC'
    ];
}
