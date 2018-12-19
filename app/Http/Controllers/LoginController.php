<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    //
	public $userModel;

	function __construct()
	{
		$this->userModel = new User();
	}

    public function showIndex()//登录
    {
    	return view('login');
    }

    public function login_sub(Request $request){
    	$this->validate($request, [
		    'email' => 'required|email',
		    'password' => 'required|min:6'
		]);
		if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
			return redirect('/#/');
		}else
		{
			return "用户名或密码错误";
		}
    }

    public function showRegistered()//注册
    {
    	return view('registered');
    }
    public function registered_sub(Request $request)//注册提交
    {
    	$this->validate($request, [
		    'name' => 'bail|required|max:255',
		    'email' => 'required|email',
		    'password' => 'required|min:6',
		    'repassword' => 'required|same:password'
		]);
		$userId =  $this->userModel->addUser($request->name,$request->email,$request->password);
		Auth::loginUsingId($userId, true);//认证 切记住用户
		return redirect('/#/');
    }
}
