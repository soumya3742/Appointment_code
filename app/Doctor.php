<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	 protected $table = 'doctor';
     protected $fillable = ['category_id','state_id','state','city_id','city','category_name','user_id','doctor_name','education','doctor_name','contact_no','created_by','status'];
 
 
 
}
