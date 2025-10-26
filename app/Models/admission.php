<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\student;
use App\Models\all_class;

class admission extends Model
{
    use HasFactory;

    protected $fillable = ['prefix','student_id','idn','class_id','grp_id','session','roll'];
}
