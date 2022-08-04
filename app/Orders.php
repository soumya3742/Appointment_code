<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'order_details';
    protected $fillable = ['order_id','user_id','payment_id'];
    // protected $primaryKey = 'order_id';
    
    public function orderproducts()
    {
       return $this->hasMany('App\OrdersProducts', 'order_id','order_id');
    }
    public function userdetails()
    {
       return $this->hasOne('App\Billing', 'order_id','order_id');
    }

    public function products_name()
    {
       return $this->hasMany('App\OrdersProducts', 'order_id','order_id')->select(['order_id','product_name']);
    }


}
