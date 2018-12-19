<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    //
    protected $table = 'race';

	public function cards()
    {
        return $this->belongsToMany('App\Card','card_race');
    }

}
