<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use App\TClass;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
class CardControlle extends Controller
{
    //
	public $cardModel;
	public $classModel;
	function __construct()
	{
		$this->cardModel = new Card();
		$this->classModel = new TClass();
	}

	public function getCardPage(Request $request)//page_sizes是条数
	{
		if($request->selectclass){
			$model = $this->classModel->find($request->selectclass)->cards;
			$model = $model->each(function($item,$key){
				$item->races;
				$item->expand;
				$item->image;
			});
			return $this->pageSplit($request->page,$model->toArray(),$request->page_sizes);
		}

		return $this->cardModel->paginate($request->page_sizes)->each(function($item,$key){
			$item->classes;
			$item->races;
			$item->expand;
			$item->image;
		});
	}

	public function cardPageInfo(Request $request)
	{
		return $this->cardModel->paginate($request->page_sizes);
	}

	public function getClass(Request $request)
	{
		// if($request->selectclass){
		// 	return $this->pageSplit($request->page,$this->classModel->find($request->selectclass)->cards->toArray(),$request->page_sizes);
		// }
		return $this->classModel->all();
	}


	function pageSplit($page,$listData,$perPage = 15) {//手动分页
		$page = $page<=0?1:$page;
	    $item = array_slice($listData, ($page-1)*$perPage, $perPage); //注释1
	    $total = count($listData);

	    $paginator =new LengthAwarePaginator($item, $total, $perPage, $page, [
	            'path' => Paginator::resolveCurrentPath(),  //注释2
	            'pageName' => 'page',
	    ]);


	    return $paginator;
	}

	public  function serach(Request $request)
	{
		$data = $this->cardModel->where('name','like','%'.$request->serach.'%')->get();
		$data = $data->each(function($item,$key){
			$item->classes;
			$item->races;
			$item->expand;
			$item->image;
		});
		return $this->pageSplit($request->page,$data->toArray(),$request->page_sizes);
	}

}
