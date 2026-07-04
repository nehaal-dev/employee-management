<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    protected $fillable = [
        'user_id','phone_number','date_of_birth','gender','address_line_1','address_line_2',
        'city','state','pincode','country','profile_photo',

    ];
protected $casts = ['certificate_name', 'institute_name','year_of_completion'];



    public function user(){
        return $this->belongsTo(User::class);
    }
}
