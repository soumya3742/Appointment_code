<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorBooking extends Model
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
	 protected $table = 'doctor_bookings';
     protected $fillable = ['user_id', 'doctor_id', 'timing'];
     
     public function user()
     {
         return $this->hasOne('App\FrontUser','id','user_id')->select(['id','name']);
     }
     
     public function doctors()
     {
         return $this->hasOne('App\Doctor','id','doctor_id');
     }
}
