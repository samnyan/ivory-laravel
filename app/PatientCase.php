<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientCase extends Model
{
    protected $table = 'patient_cases';

    public function patient()
    {
        return $this->belongsTo('App\Patient');
    }
}
