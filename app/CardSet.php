<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardSet extends Model
{
    //
    protected $table = 'cardset';
    public $timestamps = false;
    public function saveOne($code,$user_id,$class_id,$name)
    {
    	$this->code = $code;
    	$this->user_id = $user_id;
    	$this->class_id = $class_id;
    	$this->name = $name;
    	$this->save();
    	return $this->id;
    }


    public function deleteOne($user_id,$id)
    {
    	return $this->where([['user_id',$user_id],['id',$id]])->delete();
    }
}
