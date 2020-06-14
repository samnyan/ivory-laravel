<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patikkents';

    protected $primaryKey = 'id';
    public $timestamps = false;
}
