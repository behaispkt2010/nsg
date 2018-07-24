<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title','price_in', 'price_out', 'price_sale','gram','min_gram','inventory','inventory_num','kho','title_seo', 'slug', 'category','content','description','image','author_id','status','count_view', 'deleted'];
    public static function getNameById($id){
        $name = "không tìm thấy";
        $query=  Product::find($id);
        if(!empty($query)){
            $name = $query->title;
        }
        return $name;
    }
//    public static function getHotProduct(){
//        $hotProducts = Product::get();
//    }
    public static function getNewProduct(){
        $newProducts = Product::leftjoin('ware_houses','ware_houses.user_id','products.kho')
            ->leftjoin('users','users.id','ware_houses.user_id')
            ->selectRaw('products.*')
            ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho')
            ->where('products.deleted', 0)
            ->orderBy('products.id',"DESC")->take(8)->get();
        return $newProducts;

    }
    public static function getProductOfWarehouse($warehouse_id,$limit){
        $newProducts = Product::leftjoin('ware_houses','ware_houses.user_id','products.kho')
            ->leftjoin('users','users.id','ware_houses.user_id')
            ->where('ware_houses.id',$warehouse_id)
            ->selectRaw('products.*')
            ->where('products.deleted', 0)
            ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho')
            ->orderBy('products.id',"DESC")->take($limit)->get();
        return $newProducts;

    }
    public static function getBestSellerProduct($limit=0){
        if($limit==0) {
            $bestSellerProduct = ProductOrder::leftJoin('products', 'product_orders.id_product', '=', 'products.id')
                ->leftjoin('ware_houses','ware_houses.user_id','products.kho')
                ->leftjoin('users','users.id','ware_houses.user_id')
                ->groupBy('product_orders.id_product')
                ->selectRaw('products.*, count(product_orders.num) as numOrder')
                ->selectRaw('products.*, sum(product_orders.price) as priceProduct')
                ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                ->where('products.deleted', 0)
                ->orderBy('numOrder', 'DESC')
                ->get();
        }
        else{
            $bestSellerProduct = ProductOrder::leftJoin('products', 'product_orders.id_product', '=', 'products.id')
                ->leftjoin('ware_houses','ware_houses.user_id','products.kho')
                ->leftjoin('users','users.id','ware_houses.user_id')
                ->groupBy('product_orders.id_product')
                ->selectRaw('products.*, count(product_orders.num) as numOrder')
                ->selectRaw('products.*, sum(product_orders.price) as priceProduct')
                ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                ->where('products.deleted', 0)
                ->orderBy('numOrder', 'DESC')
                ->take($limit)
                ->get();
        }
        return $bestSellerProduct;
    }
    public static function getBestSellerProductByCate($cateID, $limit = 0){
        $getCate = CategoryProduct::where('parent', $cateID)->get();
        $arrCateProductID = array();
        foreach ($getCate as $itemgetCate) {
            if (!in_array($itemgetCate['id'], $arrCateProductID)){
                $arrCateProductID[] = $itemgetCate['id'];
            }
        }
        // dd($arrCateProductID);
        if($limit == 0) {
            $bestSellerProduct = ProductOrder::leftJoin('products', 'product_orders.id_product', '=', 'products.id')
                ->leftjoin('ware_houses','ware_houses.user_id','products.kho')
                ->leftjoin('users','users.id','ware_houses.user_id')
                ->whereIn('products.category', $arrCateProductID)
                ->where('products.deleted', 0)
                ->groupBy('product_orders.id_product')
                ->selectRaw('products.*, sum(product_orders.num) as numOrder')
                ->selectRaw('products.*, sum(product_orders.price) as priceProduct')
                ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho, ware_houses.confirm_kho as confirm_kho, products.id as product_ID, products.min_gram as min_kg')
                ->orderBy('numOrder', 'DESC')
                ->get();
        }
        else{
            $bestSellerProduct = ProductOrder::leftJoin('products', 'product_orders.id_product', '=', 'products.id')
                ->leftjoin('ware_houses','ware_houses.user_id','products.kho')
                ->leftjoin('users','users.id','ware_houses.user_id')
                ->whereIn('products.category',$arrCateProductID)
                ->where('products.deleted', 0)
                ->groupBy('product_orders.id_product')
                ->selectRaw('products.*, sum(product_orders.num) as numOrder')
                ->selectRaw('products.*, sum(product_orders.price) as priceProduct')
                ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho, ware_houses.confirm_kho as confirm_kho, products.id as product_ID, products.min_gram as min_kg')
                ->orderBy('numOrder', 'DESC')
                ->take($limit)
                ->get();
        }
        return $bestSellerProduct;
    }
    public static function getRelatedProduct($id,$limit){

      $getCategory=Product::find($id);
//        dd($getCategory);

        if($limit==0) {
            $getRelatedProduct = Product::leftjoin('ware_houses','ware_houses.user_id','products.kho')
                ->leftjoin('users','users.id','ware_houses.user_id')
                ->selectRaw('products.*')
                ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                ->where('products.category', $getCategory->category)
                ->where('products.deleted', 0)
                ->whereNotIn('products.id', [$id])
                ->inRandomOrder()
                ->get();
        }
        else{
            $getRelatedProduct = Product::leftjoin('ware_houses','ware_houses.user_id','products.kho')
                ->leftjoin('users','users.id','ware_houses.user_id')
                ->selectRaw('products.*')
                ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                ->where('products.category', $getCategory->category)
                ->where('products.deleted', 0)
                ->whereNotIn('products.id', [$id])
                ->inRandomOrder()
                ->take($limit)
                ->get();
        }
        return $getRelatedProduct;
    }

    public static function getBestStarsProduct($limit=0){
        if($limit==0) {
            $bestSellerProduct = Rate::leftJoin('products', 'rates.product_id', '=', 'products.id')
                ->leftjoin('ware_houses','ware_houses.user_id','products.kho')
                ->leftjoin('users','users.id','ware_houses.user_id')
                ->selectRaw('products.*')
                ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                ->groupBy('rates.product_id')
                ->selectRaw('products.*, sum(rates.rate) as numRate')
                ->where('products.deleted', 0)
                ->orderBy('numRate', 'DESC')
                ->get();
        }
        else{
            $bestSellerProduct = Rate::leftJoin('products', 'rates.product_id', '=', 'products.id')
                ->leftjoin('ware_houses','ware_houses.user_id','products.kho')
                ->leftjoin('users','users.id','ware_houses.user_id')
                ->selectRaw('products.*')
                ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                ->groupBy('rates.product_id')
                ->selectRaw('products.*, sum(rates.rate) as numRate')
                ->where('products.deleted', 0)
                ->orderBy('numRate', 'DESC')
                ->take($limit)
                ->get();
        }
        return $bestSellerProduct;
    }
    public static function getLevelKhoProduct($level, $limit = 0){
        if($limit == 0) {
            $getLevelKhoProduct = Product::leftJoin('products', 'rates.product_id', '=', 'products.id')
                ->where('level', '>=', $level)
                ->get();
        }
        else{
            $getLevelKhoProduct = Product::leftJoin('products', 'rates.product_id', '=', 'products.id')
                ->where('level', '>=', $level)
                ->take($limit)
                ->get();
        }

        return $getLevelKhoProduct;
    }
    public static function getProductByKhoVIP($limit=0){
        if($limit==0) {
            $getProductByKhoVIP = Product::leftjoin('ware_houses', 'ware_houses.user_id', 'products.kho')
                ->leftjoin('users', 'users.id', 'ware_houses.user_id')
                ->selectRaw('products.*')
                ->where('products.deleted', 0)
                ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                ->where('ware_houses.level', 3)
                ->get();
        }
        else{
            $getProductByKhoVIP = Product::leftjoin('ware_houses', 'ware_houses.user_id', 'products.kho')
                ->leftjoin('users', 'users.id', 'ware_houses.user_id')
                ->selectRaw('products.*')
                ->where('products.deleted', 0)
                ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho')
                ->where('ware_houses.level', 3)
                ->take($limit)
                ->get();
        }
        return $getProductByKhoVIP;
    }
    public static function getChildCateByCate($id){
        return CategoryProduct::where('parent', $id)->get();
    }
    public static function getProductByCate($id){

        $products = Product::leftjoin('ware_houses','ware_houses.user_id','products.kho')
            ->leftjoin('users','users.id','ware_houses.user_id')
            ->selectRaw('products.*')
            ->where('products.deleted', 0)
            ->selectRaw('ware_houses.id as idKho,ware_houses.name_company as nameKho, ware_houses.level as levelKho')
            ->where('products.category',$id)
            ->orderBy('products.id',"DESC")->take(6)->get();
        return $products;
    }
    public static function checkCountProductByLevelKho ($strKhoID){
        $arrGetKhoInfo = WareHouse::where('user_id',$strKhoID)->get();
        foreach ($arrGetKhoInfo as $itemGetInfoKho) {
            $strLevelKho = $itemGetInfoKho->level;
        }
        $check = Product::leftJoin('ware_houses','products.kho','ware_houses.user_id')
            ->where('products.kho', $strKhoID)
            ->where('products.deleted', 0)
            ->get();
        $countProduct = count($check);    
        if (($strLevelKho == 1 && ($countProduct < Util::$strNumberProductOfLevel1)) || ($strLevelKho == 2 && ($countProduct < Util::$strNumberProductOfLevel2)) || ($strLevelKho == 3 && ($countProduct < Util::$strNumberProductOfLevel3))) {
            return 1;
        }
        else {
            return 0;
        }
    }
    public static function getViewProduct ($user_id) {
        $productView = Product::where('kho', $user_id)
                        ->where('products.deleted', 0)
                        ->orderBy('count_view',"DESC")->take(10)->get();
        return $productView;             
    }
}
