<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TClass extends Model
{
    //
    protected $table = 'class';
    public $timestamps = false;
	public function cards()
    {
        return $this->belongsToMany('App\Card','card_class','class_id','card_id');
    }

}
