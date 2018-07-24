<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = ['label', 'link','parent','sort','class', 'deleted'];
    static public function get_numberChil($id){
       return Menu::where('parent', $id)->where('deleted', 0)->count();
    }
    static public function get_parent(){
        return Menu::where('parent','<>', 0)->where('deleted', 0)->count();
    }
    static public  function get_arrayChil($id){
        return Menu::where('parent', $id)->where('deleted', 0)->get();
    }
    static public function get_menu($data,$parent = 0)
    {
        foreach($data as $key=>$itemMenu1) {
            if ($parent == $itemMenu1->parent) {
                $numchil = Menu::get_numberChil($itemMenu1->id);
                if ($numchil == 0) {
                    echo '<li class="dd-item" data-label="' . $itemMenu1->label . '" data-url="'.$itemMenu1->link .'" data-class="'.$itemMenu1->class. '">
                                        <div class="dd-handle"> ' . $itemMenu1->label . '  </div>
                                        <i class="fa fa-times delete-menu"></i>
                                    </li>';
                } else {
//                    $arraySub = Menu::get_arrayChil($itemMenu1->id);
                    echo ' <li class="dd-item" data-label="' . $itemMenu1->label . ' " data-url="'.$itemMenu1->link.'" data-class="'.$itemMenu1->class. '">
                                        <div class="dd-handle"> ' . $itemMenu1->label . ' </div>
                                        <i class="fa fa-times delete-menu"></i>
                                    ';
                    echo ' <ol class="dd-list">';
                        $parent1 = $itemMenu1->id;
                        Menu::get_menu($data, $parent1);
                    echo '</ol></li>';

                }

            }
        }
    }

    static public function get_menu_frontend($parent=0)
    {
        $data = Menu::get();
        foreach($data as $key=>$itemMenu1) {
            if ($parent == $itemMenu1->parent) {
                $numchil = Menu::get_numberChil($itemMenu1->id);
                if ($numchil == 0) {
                    echo ' <li class="theme_menu '.$itemMenu1->class.'"><a href="'.url('/').$itemMenu1->link.'" style="height: 41px; ">'.$itemMenu1->label.'</a></li>';
                } else {
                    echo '   <li class="has_submenu">
                                            <a href="'.$itemMenu1->link.'" style="height: 41px;">'.$itemMenu1->label.'</a>
                                           ';
                    echo ' <ul class="theme_menu submenu">';
                    $parent1 = $itemMenu1->id;
                    Menu::get_menu_frontend($parent1);
                    echo '</ul></li>';

                }

            }
        }
    }
    static public function get_menu_frontend_full ($parent=0)
    {
        $data = Menu::get();
        foreach($data as $key => $itemMenu1) {
            if ($parent == $itemMenu1->parent) {
                $numchil = Menu::get_numberChil($itemMenu1->id);
                if ($numchil == 0) {
                    if ($itemMenu1->parent == 0) {
                        if ($itemMenu1->class == 'isproduct') {
                        echo '<li class="has_megamenu animated_item" style="width: auto;float: left;">
                                <a href="#">'.$itemMenu1->label.'</a>
                                <div class="col-md-12 col-sm-12 mega_menu type_4 clearfix" style="margin-left: -165px;">';
                                    CategoryProduct::get_cate_frontend();
                        echo '  </div>
                              </li>';
                        } else {
                            echo '<li class="has_megamenu animated_item" style="width: auto;float: left;">
                                <a href="#">'.$itemMenu1->label.'</a>';
                            echo '</li>';
                        }
                    } else {
                        echo '<div class="mega_menu_item">'; 
                        echo '<h6><a href="'.$itemMenu1->link.'"><b>'.$itemMenu1->label.'</b></a></h6>';
                        echo '</div>';
                    }
                } else {
                    echo '<li class="has_megamenu animated_item" style="width: auto;float: left;">
                            <a href="#">'.$itemMenu1->label.'</a>
                            <div class="col-md-12 col-sm-12 mega_menu type_4 clearfix" style="margin-left: -165px;">';
                                $parent1 = $itemMenu1->id;
                                Menu::get_menu_frontend_full($parent1);  
                    echo '  </div>
                          </li>';
                }
            }
        }
    }
}
