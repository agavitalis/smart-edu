<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRegExcel extends Model
{
	
    protected $fillable = array(
        'name','username','gender','class','level','session','term' 
    );


     protected $hidden = [
        'id', 'remember_token','created_at','updated_at'
    ];

}
