<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class inst_info extends Model
{
    protected $fillable = ['inst_name','inst_addr','inst_phone','inst_phone2','inst_email','db_prefix','web_head'];

    public function user(){
	    return $this->belongsTo(User::class,'id','id')->belongsTo(User::class,'id',41);
	}
}