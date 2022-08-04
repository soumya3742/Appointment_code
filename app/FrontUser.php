<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Hash;
class FrontUser extends Model
{
    protected $fillable = ['id','name','email','mobile','password','state','city','referal_by','reporter'];
    protected $table = 'front_users';
    use HasApiTokens;
    public static function saveFrontUser()
    {
        return DB::table('front_users')->insertGetId([
            'name'=>request('name'),
            'user_type'=>'user',
            'email'=>request('email'),
            'mobile'=>request('mobile'),
            'password'=>Hash::make(request('password')),
            'created_at'=>date('Y-m-d h:s:i')
            ]);
    }
    
    public function states()
    {
        return $this->hasOne('App\States','id','state')->select(['id','name']);
    }
    
    public function cities()
    {
        return $this->hasOne('App\City','id','city')->select(['id','city']);
    }
    
    public function referalby()
    {
        return $this->hasOne('App\FrontUser','mobile','referal_by')->select(['id','name','mobile']);        
    }

}
