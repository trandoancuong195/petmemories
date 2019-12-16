<?php
namespace App\src\admin\Repositories;
 
use App\Product;
use App\Base\Repositories\RepositoryBase;
class AdminReponsitories extends RepositoryBase {
	protected $model;
    protected $helper;
    protected $config;
	function __construct(Product $product){
		$this->model = new product();
	}
	function getAllProduct(){
		return $this->model::all();
	}
}