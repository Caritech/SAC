<?php

namespace Modules\VLife\Entities;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table = "vlife_contacts";
    protected $guarded = ['id'];


    public function address()
    {
        return $this->hasMany('Modules\VLife\Entities\Contacts\Address', 'contact_id');
    }
    public function achievement()
    {
        return $this->hasOne('Modules\VLife\Entities\Contacts\Achievement', 'contact_id');
    }
    public function preference()
    {
        return $this->hasOne('Modules\VLife\Entities\Contacts\Preference', 'contact_id');
    }
    public function company()
    {
        return $this->hasMany('Modules\VLife\Entities\Contacts\Company', 'contact_id');
    }
    public function notes()
    {
        return $this->hasOne('Modules\VLife\Entities\Contacts\Notes', 'contact_id');
    }
    public function education()
    {
        return $this->hasOne('Modules\VLife\Entities\Contacts\Education', 'contact_id');
    }
    public function family()
    {
        return $this->hasOne('Modules\VLife\Entities\Contacts\Family', 'contact_id');
    }
    public function health()
    {
        return $this->hasOne('Modules\VLife\Entities\Contacts\Health', 'contact_id');
    }
    public function valuesBeliefs()
    {
        return $this->hasOne('Modules\VLife\Entities\Contacts\ValuesBeliefs', 'contact_id');
    }
}
