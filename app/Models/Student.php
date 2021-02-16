<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name', 'username', 'email','date_of_birth','phone','gender','state','country','address','lga','class','level','house','session','term','skills','intrest','quotes','posts_held'
    ];
}
