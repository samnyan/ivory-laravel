<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_detail';

    protected $primaryKey = 'id';

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
