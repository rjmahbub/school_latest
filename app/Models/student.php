<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\admission;
use App\Models\all_class;

class student extends Model
{
    use HasFactory;

    protected $fillable = ['prefix','full_name','dob','father','mother','gender','phone','phone2','email','present_addr','permanent_addr','photo'];

    public function admission(){
        return $this->belongsTo('App\Models\admission','student_id','id');
    }
}
