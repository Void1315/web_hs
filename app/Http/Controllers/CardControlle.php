<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use Illuminate\Support\Facades\Auth;
use App\TClass;
use App\CardSet;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
class CardControlle extends Controller
{
    //
	public $cardModel;
	public $classModel;
	public $cardSetModel;
	function __construct()
	{
		$this->cardModel = new Card();
		$this->classModel = new TClass();
		$this->cardSetModel = new CardSet();
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
		$data = $this->cardModel->where('name','like','%'.$request->serach.'%')->orWhere('description','like','%'.$request->serach.'%')->get();
		$data = $data->each(function($item,$key){
			$item->classes;
			$item->races;
			$item->expand;
			$item->image;
		});
		return $this->pageSplit($request->page,$data->toArray(),$request->page_sizes);
	}

	public function serachClassCard(Request $request)
	{
		$data = $this->classModel->where('id','=',$request->class_id)
		->get();
		$data = $data->each(function($item,$key){
			$item->cards;
		});
		return $this->pageSplit($request->page,$data->get(0)->cards->toArray(),$request->page_sizes);
		// return $this->pageSplit(0,$data->get(0)->cards->toArray(),20);
		// return dd($data->get(0)->cards->toArray());
		// return $data->collapse();
	}

	public function serachNeutralCard(Request $request)
	{

	}

	public function serachId(Request $request)
	{
		$collection = collect();
		return $this->cardModel->whereIn('id',$request->arr_id)->get();
	}

	public function saveSet(Request $request)
	{
		return $this->cardSetModel->saveOne($request->code,Auth::user()->id,$request->class_id,$request->name);
	}

	public function deleteSet(Request $request)
	{
		return $this->cardSetModel->deleteOne(Auth::user()->id,$request->set_id);
	}

}
