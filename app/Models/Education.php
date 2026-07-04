<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';
    
    protected  $fillable=[
        'user_id','certificate_name','institute_name','year_of_completion','document_file'
        ] ;



    public function user(){
        return $this->belongsTo(User::class);
    }
}
