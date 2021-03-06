<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'UserType','password','username','dateofbirth','phone','gender','state','country','address','lga','yoa','class','level','house','session','term','skills','intrest','quotes','postsheld'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function school_fee_invoices()
    {
        return $this->hasMany(SchoolFeeInvoice::class);
    }
}
