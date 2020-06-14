<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function patientCases()
    {
        return $this->hasMany('App\PatientCase');
    }
}
