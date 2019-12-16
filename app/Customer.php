<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Customer extends Authenticatable
{
    //
    protected $table = 'customer';
    protected $fillable = [
        'cus_name', 'cus_mail', 'cus_password', 'cus_address','cus_phone'
    ];
}
