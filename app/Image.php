<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $table = 'image';
    public $timestamps = false;

    public function addImage($path)//保存图片并返回id
    {
    	$this->path = $path;
    	$this->save();
    	return $this->id;
    }

}
