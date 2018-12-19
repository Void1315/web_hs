<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Image;
class UserController extends Controller
{
    //
	public $userModel;
	public $imageModel;
	function __construct()
	{
		$this->userModel = new User();
		$this->imageModel = new Image();
	}

	public function userImg()//用户头像
	{
		# code...
		if(Auth::user()){
			$this->userModel = Auth::user();
			return asset(substr($this->userModel->image->path,2));
		}
		else{
			return "未登录";
		}
	}

	public function userInfo()
	{
		return Auth::user()->get()->each(function($item, $key){
			$item =  $item->image;
		});
	}

	public function uploadImg(Request $request)//上传图片并修改
	{
		$path = Storage::disk('image')->putFile('', $request->file('img'));
		$image_path = "./imgage/".$path;
		$id = $this->imageModel->addImage($image_path);
		Auth::user()->img_id = $id;
		Auth::user()->save();
		return $image_path;
	}

	public function changeInfo(Request $request)//修改个人信息
	{
		$this->validate($request, [
		    'name' => 'bail|required|max:255',
		]);
		$userModel = Auth::user();
		$userModel->name = $request->name;
		$userModel->save();
		return response()->json([
	    	'data' => '修改成功!',
	    	'state' => '200'
		]);

	}


}
