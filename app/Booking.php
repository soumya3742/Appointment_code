<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'booking';
    protected $fillable = ['name','email','mobile_no','date','time','no_of_people','code_human'];

}
