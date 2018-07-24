<?php

namespace App\Http\Controllers\Frontend;

use App\CategoryWarehouse;
use App\Mail\Contact;
use App\Mail\OrderInfo;
use App\Notification;
use App\Util;
use App\WareHouse;
use App\Product;
use App\HelpMenu;
use App\HelpMenuContent;
use App\Events\ViewsCompanyEvents;
use App\Events\ViewsWareHouseEvents;
use App\CompanyImage;
use App\NewsCompany;
use App\CategoryProduct;
use App\Company;
use App\WarehouseImageDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LandingPageController extends Controller {
    public function LandingPage($content){
        $data =[
            "content" => $content
        ];
        return view('frontend.landingpage', $data);
    }
    public function dataJsTree () {
        $data = HelpMenu::get()->toArray();
        $itemsByReference = array();
        foreach($data as $key => &$item) {
            $itemsByReference[$item['id']] = &$item;
           // Children array:
            $itemsByReference[$item['id']]['children'] = array();
           // Empty data class (so that json_encode adds "data: {}" ) 
            $itemsByReference[$item['id']]['data'] = new \StdClass();
        }
        // Set items as children of the relevant parent item.
        foreach($data as $key => &$item) {
            $item['a_attr']['href'] = $item['link'];
            if ($item['parent_id'] && isset($itemsByReference[$item['parent_id']])) 
                $itemsByReference [$item['parent_id']]['children'][] = &$item;
        }
        // Remove items that were added to parents elsewhere:
        foreach($data as $key => &$item) {
            /*if(empty($item['children'])) {
                $item['a_attr']['href'] = $item['link'];
            }*/
            if($item['parent_id'] && isset($itemsByReference[$item['parent_id']]))
                unset($data[$key]);
        }
        $data = array_values($data);
        return json_encode($data);
    }
    public function help_home(){
        
        return view('frontend.help_home');

    }
    public function help_menu($linkMenu){
        if (!empty($linkMenu)) {
            $helpMenu = HelpMenu::where('link','LiKE','%'.'/tro-giup/'.$linkMenu.'%')->first();
        }
        $data = [
            'helpMenu' => $helpMenu,
        ];
        return view('frontend.help_menu', $data);

    }
}
