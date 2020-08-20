<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Package extends Model
{
    protected $fillable= ['transaction_id'];
}
