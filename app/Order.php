<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function doctor()
    {
        return $this->belongsTo('App\User', 'doctor_id', 'id');
    }

    public function professor()
    {
        return $this->belongsTo('App\User', 'professor_id', 'id');
    }

    /**
     * Get the clinic that own this oder
     */
    public function clinic()
    {
        return $this->belongsTo('App\Clinic');
    }

    public function fapiao()
    {
        return $this->hasOne('App\Fapiao');
    }

    public function orderDetail()
    {
        return $this->hasMany('App\OrderDetail');
    }

    public function patientCase()
    {
        return $this->belongsTo('App\PatientCase');
    }

    public function address()
    {
        return $this->hasOne('App\Address', 'id', 'address_id');
    }
}
