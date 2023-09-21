<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable as AuthorizableContract;

class Customers extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'name', 'email', 'phone', 'address'
    ];
}
