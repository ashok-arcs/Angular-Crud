<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable as AuthorizableContract;

class Products extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'name', 'price', 'description'
    ];
}