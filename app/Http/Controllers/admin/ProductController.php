<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use App\src\admin\Repositories\AdminReponsitories;
class ProductController extends Controller
{
    protected $prd;
    public function __construct(AdminReponsitories $prd){
        $this->prd = $prd;
    }

    public function index()
    {
        // List all the products
        if($this->middleware('auth')){
            return $this->prd->getAllProduct();
        }
        else {
            echo 'bạn chưa đăng nhập';
            die;
        }
    }

    public function store(Request $request)
    {
        // Create new product
        $product = new Product();
        $product->sku = $request->sku;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();
    }
    public function updateLikeStatus($id){
        $prd=Product::find($id);
        if($prd->like_status==0){
            $prd->like_status=1;
        }else{
            $prd->like_status=0;
        }
        $prd->save();
    }
    public function show($id)
    {
        // Show single product
        return Product::find($id);
    }

    public function update(Request $request, $id)
    {
        // Update the Product
        if ($id != null) {
            Product::where('id', $id)->update($request->all());  
        }
    }

    public function destroy($id)
    {
        // Delete the Product
        if ($id != null) {
            $product = Product::find($id);
            $product->delete();    
        }
    }
}