<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    public function user()
    {
        return $this->belongsTo('App\User');
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
}
