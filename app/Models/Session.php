<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
     protected $fillable = array(
        'name','current',
    );
}