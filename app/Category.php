<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $parent
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereParent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'parent', 'deleted'];

    public static function getNameCateById($id)
    {
        $name = "mặc định";
        $query = Category::find($id);
        if (!empty($query)) {
            $name = $query->name;
        }
        return $name;
    }

    public static function getAllCategory()
    {
        return Category::get();
    }

    public static function getSlugCategory($id)
    {
        $slug = "mac-dinh";
        $query = Category::find($id);
        if (!empty($query)) {
            $slug = $query->slug;
        }
        return $slug;
    }

    static public function CateMulti($data, $parent_id = 0, $str = "&nbsp&nbsp&nbsp", $select = 0)
    {
        foreach ($data as $val) {
            $id = $val->id;
            $name = $val->name;
            $parent = $val->parent;
            /*if ($val['parent'] == $parent_id) { 

                if ($select != 0 && $id == $select) {
                    echo '<option value="' . $id . '" selected>' . $str . " " . $name . '</option>';
                } elseif ($parent == 0) {
                    echo '<optgroup label="' . $name . '"></optgroup>';
                } else {
                    echo '<option value="' . $id . '">' . $str . " " . $name . '</option>';
                }
                Category::CateMulti($data, $id, $str . "&nbsp&nbsp&nbsp&nbsp", $select);
            }*/
            if ($val['parent'] == $parent_id) { 
                if ($parent == 0) {
                    echo '<optgroup label="' . $name . '">';

                }
                elseif ($select != 0 && $id == $select) {
                    echo '<option value="' . $id . '" selected>' . $str . " " . $name . '</option>';
                } else {
                    echo '<option value="' . $id . '">' . $str . " " . $name . '</option>';
                }
                Category::CateMulti($data, $id, $str . "&nbsp&nbsp&nbsp", $select);
                if ($parent == 0) {
                    echo '</optgroup>';
                }
            }
        }

    }

    static public function get_numberChil($id)
    {
        return Category::where('parent', $id)->count();
    }

    static public function get_menu_cate_frontend($parent = 0)
    {
        $data = Category::get();
        foreach ($data as $key => $itemMenu1) {
            if ($parent == $itemMenu1->parent) {
                $numchil = Category::get_numberChil($itemMenu1->id);
//                dd($numchil);
                if ($numchil == 0) {
                    echo '<li class=""><a href="' . url("/category-blog/$itemMenu1->slug") . '">' . $itemMenu1->name . '</a></li>';
                } else {
                    echo '     <li class="has_megamenu"><a href="' . url("/category-blog/$itemMenu1->slug") . '">' . $itemMenu1->name . '</a>
                <div class="mega_menu clearfix">

                <div class="mega_menu_item">

                    <ul class="list_of_links">
                     ';


                    $parent1 = $itemMenu1->id;
                    Category::get_menu_cate_frontend($parent1);

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
