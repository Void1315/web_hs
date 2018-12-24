<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Image;
use App\CardSet;
class UserController extends Controller
{
    //
	public $userModel;
	public $imageModel;
	public $cardSetModel;
	function __construct()
	{
		$this->userModel = new User();
		$this->imageModel = new Image();
		$this->cardSetModel = new CardSet();
	}

	public function userImg()//用户头像
	{
		# code...
		if(Auth::user()){
			$this->userModel = Auth::user();
			return asset(substr($this->userModel->image->path,2));
		}
		else{
			return response('未登录', 422);
		}
	}

	public function userInfo()
	{
		$user = $this->userModel->where('id',Auth::user()->id);
		return $user->get()->each(function($item, $key){
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
		    'name' => 'bail|required|max:20',
		]);
		$userModel = Auth::user();
		$userModel->name = $request->name;
		$userModel->save();
		return response()->json([
	    	'data' => '修改成功!',
	    	'state' => '200'
		]);

	}

	public function defaultImg()
	{
		return $this->imageModel->find(1);
	}

	public function getCardSet(Request $request)
	{
		return $this->cardSetModel->where('user_id',Auth::user()->id)->get();
	}


	public function updataCardSet(Request $request)
	{
		$model = $this->cardSetModel->find($request->id);
		$model->code = $request->code;
		$model->save();
		return response()->json([
	    	'data' => '修改成功!',
	    	'state' => '200'
		]);
	}

	public function deleteCardSet(Request $request)
	{
		$this->cardSetModel->find($request->id)->delete();
		return response()->json([
	    	'data' => '修改成功!',
	    	'state' => '200'
		]); 
	}

	public function isUser()
	{
		if(Auth::check()){


			return response()->json([
				'data' => '认证成功!',
		    	'state' => '200'
			]);
			setcookie("islogin","true");
		}
		else{
			return response('没有认证!', 421);
			setcookie("islogin","false");
		}
	}

	public function signOut()
	{
		Auth::logout();
		return response()->json([
				'data' => '退出!',
		    	'state' => '200'
			]);
	}

	public function getPermission()
	{
		return response()->json([
			'data'=>Auth::user()->permission,
			'state' => '200'
		]);
	}


	public function getUserAll()
	{
		return $this->userModel->withTrashed()->get();
	}

	public function updataUserInfo(Request $request)
	{
		$this->validate($request, [
		    'name' => 'bail|required|max:20',
		]);
		$user = $this->userModel->find($request->id);
		if(Auth::user()->permission > $user->permission){
			$user->name = $request->name;
			$user->permission = $request->permission;
			$user->save();
			return response()->json([
				'data'=>'修改成功!',
				'state' => '200'
			]);
		}else{
			return response('无权限!', 421);
		}
		
	}

	public function deletedUser(Request $request)
	{
		$user = $this->userModel->find($request->id);
		if(Auth::user()->permission > $user->permission&&$request->id!=Auth::user()->id){
			$user->delete();
			return response()->json([
				'data'=>'修改成功!',
				'state' => '200'
			]);
		}else{
			return response('无权限!', 421);
		}
	}

	public function unsealingUser(Request $request)
	{
		$user = $this->userModel->withTrashed()->where('id',$request->id);
		if(Auth::user()->permission > $user->permission&&$request->id!=Auth::user()->id){
			$user->restore();
			return response()->json([
				'data'=>'修改成功!',
				'state' => '200'
			]);
		}else{
			return response('无权限!', 421);
		}
	}

}
