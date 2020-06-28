<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';

    public $incrementing = false;

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];

    public function patientCases()
    {
        return $this->hasMany('App\PatientCase');
    }

    public function doctor()
    {
        return $this->belongsTo('App\User');
    }
}
