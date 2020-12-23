<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    //test
    protected $table = "vlife_contacts";
    protected $guarded = ['id'];

    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        $age = null;

        if ($this->dob != null) {
            $age = (new \Carbon\Carbon($this->dob))->age;
        }
        return $age;
    }



    public function address()
    {
        return $this->hasMany('App\Models\Contacts\Address', 'contact_id');
    }
    public function achievement()
    {
        return $this->hasOne('App\Models\Contacts\Achievement', 'contact_id');
    }
    public function preference()
    {
        return $this->hasOne('App\Models\Contacts\Preference', 'contact_id');
    }
    public function company()
    {
        return $this->hasMany('App\Models\Contacts\Company', 'contact_id');
    }
    public function notes()
    {
        return $this->hasOne('App\Models\Contacts\Notes', 'contact_id');
    }
    public function education()
    {
        return $this->hasOne('App\Models\Contacts\Education', 'contact_id');
    }
    public function family()
    {
        return $this->hasOne('App\Models\Contacts\Family', 'contact_id');
    }
    public function health()
    {
        return $this->hasOne('App\Models\Contacts\Health', 'contact_id');
    }
    public function valuesBeliefs()
    {
        return $this->hasOne('App\Models\Contacts\ValuesBeliefs', 'contact_id');
    }
}
