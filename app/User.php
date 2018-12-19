<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    //
    use Notifiable;
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	public function addUser($name,$email,$password)
	{
		$this->name = $name;
		$this->email = $email;
		$this->password = Hash::make($password);
		$this->save();
		return $this->id;
	}

	public function image()
    {
        return $this->hasOne('App\Image','id','img_id');
    }

}
