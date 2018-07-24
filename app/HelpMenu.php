<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpMenu extends Model
{
    protected $table = 'help_menu';
    protected $fillable = ['text','parent_id','content','link','status', 'deleted'];

    public static function getHelpMenuById($id){
        $name = "Mặc định";
        $query=  HelpMenu::find($id);
        if(!empty($query)){
            $name = $query->text;
        }
        return $name;
    }
    static public function get_numberChil($id) {
        return HelpMenu::where('parent_id', $id)->where('status', 1)->where('deleted', 0)->count();
    }
    static public function get_numberParent($id) {
        return HelpMenu::where('parent_id','<>', 0)->where('deleted', 0)->count();
    }
    static public function getHelpChilOf($id) {
        return HelpMenu::where('parent_id', $id)->where('status', 1)->where('deleted', 0)->get();
    }
}
