<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolFeeInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoice_number",
        "session",
        "level",
        "term",
        "amount",
        "amount_paid",
        "is_paid",
        "user_id",
        "status"
    ];

}
