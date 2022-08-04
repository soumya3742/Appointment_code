<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	 protected $table = 'category';
    protected $fillable = ['title'];

	public function parent_detail()
    {
       return $this->hasOne('App\Category', 'id', 'parent_id');
    }




}
