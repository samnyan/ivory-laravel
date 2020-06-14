<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fapiao extends Model
{
    protected $table = 'fapiaos';

    public function order()
    {
        $this->belongsTo('App\Order');
    }
}
