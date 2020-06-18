<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $table = 'clinics';

    public function users()
    {
        return $this->hasMany('App\User', 'clinic_id', 'id');
    }
}
