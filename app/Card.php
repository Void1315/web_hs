<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //
    protected $table = 'card';
    public $timestamps = false;
    public function races()
    {
        return $this->belongsToMany('App\Race','card_race');
    }

    public function classes()
    {
        return $this->belongsToMany('App\TClass','card_class','card_id','class_id');
    }

    public function expand()
    {
        return $this->hasOne('App\Expand','id','expand_id');
    }

    public function image()
    {
        return $this->hasOne('App\Image','id','img_id');
    }

}
