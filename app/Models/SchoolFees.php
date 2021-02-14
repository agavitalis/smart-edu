<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolFees extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'session', 'level','term','allow_part_payment'
    ];
}
