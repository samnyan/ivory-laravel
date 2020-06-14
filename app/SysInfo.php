<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysInfo extends Model
{
    //
    protected $table = 'sysinfo';

    protected $primaryKey = 'id';
    public $timestamps = false;
}
