<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $table = 'clinics';

    public function doctors()
    {
        return $this->hasMany('App\User');
    }
}
