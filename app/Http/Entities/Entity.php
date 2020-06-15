<?php

namespace App\Http\Entities;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    public $timestamps = true;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
