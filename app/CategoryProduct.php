<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $fillable = ['name', 'slug','note','parent','cate_code', 'deleted'];
    public static function getNameCateById($id){
        $name = "Mặc định";
        $query=  CategoryProduct::find($id);
        if(!empty($query)){
            $name = $query->name;
        }
        return $name;
    }
    public static function getCate(){
        return CategoryProduct::where('disable', 0)->where('deleted', 0)->get();
    }
    public static function getAllCategoryProduct(){
        return CategoryProduct::where('disable', 0)->where('deleted', 0)->get();
    }
    public static function getSlugCategoryProduct($id){
        $slug = "mac-dinh";
        $query=  CategoryProduct::find($id);
        if(!empty($query)){
            $slug = $query->slug;
        }
        return $slug;
    }
    public static function getTonKho($id_cate = 0, $id_kho = 0){
        if($id_cate != 0 && $id_kho != 0){
            $product = Product::where('kho', $id_kho)
                ->where('category', $id_cate)
                ->where('deleted', 0)
                ->groupBy('category')
                ->selectRaw('sum(inventory_num) as inventory_num, count(*) as numproduct')
                ->first();
        }
        else if($id_kho == 0){
            $product = Product::where('category', $id_cate)
                ->where('deleted', 0)
                ->groupBy('category')
                ->selectRaw('sum(inventory_num) as inventory_num, count(*) as numproduct')
                ->first();
        }
        else {
            $product = Product::where('kho', $id_kho)
                ->where('category', $id_cate)
                ->where('deleted', 0)
                ->groupBy('category')
                ->selectRaw('sum(inventory_num) as inventory_num, count(*) as numproduct')
                ->first();
        }
        $inventory_num = 0;
        $numproduct    = 0;
        if(count($product) != 0){
            $inventory_num = $product->inventory_num;
            $numproduct    = $product->numproduct;
        }
        $data = [
        'inventory_num' => $inventory_num,
        'numproduct'    => $numproduct
        ];

        return $data;
    }
    static public function get_numberChil($id) {
        return CategoryProduct::where('parent',$id)->where('disable',0)->where('deleted', 0)->count();
    }
    static public function get_menu_cate_frontend($parent = 0)
    {
        $data = CategoryProduct::where('disable', 0)->where('deleted', 0)->get();
        foreach($data as $key => $itemMenu1) {
            if ($parent == $itemMenu1->parent) {
                $numchil = CategoryProduct::get_numberChil($itemMenu1->id);
//                dd($numchil);
                if ($numchil == 0) {
                    echo '<li class=""><a href="'.url("/category-product/$itemMenu1->slug").'">'.$itemMenu1->name.'</a></li>';
                } else {
                    echo '<li class="has_megamenu"><a href="#" ><div class="img_cate"><img src="'.url('images/'.$itemMenu1->slug.'.png').'"></div>'.$itemMenu1->name.'</a>
                <div class="mega_menu clearfix">

                <div class="mega_menu_item">

                    <ul class="list_of_links">
                     ';


                    $parent1 = $itemMenu1->id;
                    CategoryProduct::get_menu_cate_frontend($parent1);

                    echo '
                    </ul>

                </div><!--/ .mega_menu_item-->

            </div><!--/ .mega_menu-->
            </li>';

                }

            }
        }
    }
    static public function get_cate_frontend($parent=0)
    {
        $data = CategoryProduct::where('disable', 0)->where('deleted', 0)->get();
        $i    = 0;
        foreach($data as $key => $itemMenu1) {
            $strCateID  = $itemMenu1->id;
            if ($parent == $itemMenu1->parent) {
                $numchil = CategoryProduct::get_numberChil($itemMenu1->id);
                if ($numchil == 0) {
                    echo '<li><a href="'.url("/category-product/$itemMenu1->slug").'">'.$itemMenu1->name.'</a></li>';
                } else {
                    $i++;
                    echo '<div class="mega_menu_item">';
                    echo '<h6><b>'.$itemMenu1->name.'</b></h6>
                            <ul class="list_of_links">';
                            $parent1 = $itemMenu1->id;
                            CategoryProduct::get_cate_frontend($parent1);
                    echo '  </ul>';
                    echo '</div>';
                }
            }
            if ($i==4) {
                echo '<div style="clear: both;"></div>';
            }
        }

    }
    static public function get_cate_frontend_footer($parent=0)
    {
        $data = CategoryProduct::where('disable', 0)->where('deleted', 0)->get();
        $i = 0;
        foreach($data as $key => $itemMenu1) {
            $strCateID = $itemMenu1->id;
            if ($parent == $itemMenu1->parent) {
                $numchil = CategoryProduct::get_numberChil($itemMenu1->id);
                if ($numchil == 0) {
                    echo '<li><a href="'.url("/category-product/$itemMenu1->slug").'" class="colorwhite">'.$itemMenu1->name.'</a></li>';
                } else {
                    $i++;
                    echo '<div class="mega_menu_item_footer">';
                    echo '<h6 class="colorwhite"><b>'.$itemMenu1->name.'</b></h6>
                            <ul class="list_of_links">';
                            $parent1 = $itemMenu1->id;
                            CategoryProduct::get_cate_frontend_footer($parent1);
                    echo '  </ul>';
                    echo '</div>';
                }
            }
            if ($i==5) {
                echo '<div style="clear: both;"></div>';
            }
        }

    }

    static public function get_menu_help_frontend($parent=0)
    {
        $data = CategoryProduct::where('disable', 0)->where('deleted', 0)->get();
        foreach($data as $key => $itemMenu1) {
            if ($parent == $itemMenu1->parent) {
                $numchil = CategoryProduct::get_numberChil($itemMenu1->id);
//                dd($numchil);
                if ($numchil == 0) {
                    echo '<li class=""><a href="'.url("/category-product/$itemMenu1->slug").'">'.$itemMenu1->name.'</a></li>';
                } else {
                    echo '<li class="has_megamenu"><a href="#" ><div class="img_cate"><img src="'.url('images/'.$itemMenu1->slug.'.png').'"></div>'.$itemMenu1->name.'</a>
                <div class="mega_menu clearfix">

                <div class="mega_menu_item">

                    <ul class="list_of_links">
                     ';


                    $parent1 = $itemMenu1->id;
                    CategoryProduct::get_menu_cate_frontend($parent1);

                    echo '
                    </ul>

                </div><!--/ .mega_menu_item-->

            </div><!--/ .mega_menu-->
            </li>';

                }

            }
        }

    }
}
