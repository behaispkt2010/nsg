<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use DateTime;

/**
 * App\Util
 *
 * @mixin \Eloquent
 */
class Util extends Model
{
    public static $datetest = 20;
    public static $mailadmin = 'behaispkt2010@gmail.com';
    /*Notify Admin | Nhân Viên*/
    public static $dangkychukho = "dangkychukho";
    public static $upgradeLevelKho = "upgradeLevelKho";
    public static $quangcaoKho = "quangcaoKho";
    public static $confirmkho = "confirmkho";
    public static $dangkytraphiKho = "dangkytraphiKho";
    public static $dangkygiahanKho = "dangkygiahanKho";


    public static $dangkycompany = "dangkycompany";
    public static $upgradeLevelCompany = "upgradeLevelCompany";
    public static $quangcaoCompany = "quangcaoCompany";
    public static $confirmCompany = "confirmCompany";
    public static $dangkytraphiCompany = "dangkytraphiCompany";
    public static $dangkygiahanCompany = "dangkygiahanCompany";

    public static $newproduct = "newproduct";
    public static $newscompany = "newscompany";
    public static $contact = "contact";

    /*Notify Chủ kho*/
    public static $dangkychukhoSuccess = "dangkychukhoSuccess";
    public static $upgradeLevelKhoSuccess = "upgradeLevelKhoSuccess";
    public static $quangcaoSuccess = "quangcaoSuccess";
    public static $confirmkhoSuccess = "confirmkhoSuccess";
    public static $dangkytraphiSuccess = "dangkytraphiSuccess";
    public static $dangkygiahanSuccess = "dangkygiahanSuccess";
    public static $newproductSuccess = "newproductSuccess";

    /*Notify Company*/
    public static $dangkychuCompanySuccess = "dangkychuCompanySuccess";
    public static $upgradeLevelCompanySuccess = "upgradeLevelCompanySuccess";
    public static $quangcaoCompanySuccess = "quangcaoCompanySuccess";
    public static $confirmCompanySuccess = "confirmCompanySuccess";
    public static $dangkytraphiCompanySuccess = "dangkytraphiCompanySuccess";
    public static $dangkygiahanCompanySuccess = "dangkygiahanCompanySuccess";
    public static $newscompanySuccess = "newscompanySuccess";



    public static $roleviewAdmin = "1";
    // public static $roleviewStaffOffice = "7";
    public static $roleviewChukho = "chukho";
    public static $userexpired = "userexpired";
    public static $ordernew = "ordernew";
    public static $orderfail = "orderfail";
    public static $orderreturn = "orderreturn";
    public static $statusOrderSuccess = 8;
    public static $statusOrderFail = 9;
    public static $statusOrderReturn = 10;
    public static $strNumberProductOfLevel1 = 5;
    public static $strNumberProductOfLevel2 = 20;
    public static $strNumberProductOfLevel3 = 100;

// chỉ phân quyền cho user là Nhân Viên + trực thuộc quản lý của admin - không có role Chủ Kho, Công ty và Khách hàng
    public static $viewAll = ['admin','editor'];
    public static $viewDriver = ['admin','editor'];
    public static $viewCompany = ['admin','editor','staff'];
    public static $viewCategory = ['admin','editor'];
    public static $viewHistoryInput = ['admin','editor'];
    public static $viewInventory = ['admin','editor'];
    public static $viewNewsCompany = ['admin','editor'];
    public static $viewWareHouse = ['admin','editor'];
    public static $viewProduct = ['admin','editor'];
    public static $viewDashboard = ['admin','editor'];

    public static function saveFile($file, $type)
    {
        $today = date("Y-m-d_H-i-s");
        $folderFile = date("Y-m");
        $file_name = 'web-' . $today . '-' . static::builtSlug($file->getClientOriginalName());
        if ($type == '') {
            $destinationPath = 'uploads/images/';
        } else if ($type == "file") {
            $destinationPath = 'uploads/files/';
        } else if ($type == "video") {
            $destinationPath = 'uploads/videos/' ;
        } else if ($type == "audio") {
            $destinationPath = 'uploads/audios/' ;
        }
        else{
            $destinationPath = 'uploads/orders/';
        }
        $destinationPath = $destinationPath.$folderFile;
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, TRUE);
        }
        $file->move($destinationPath, $file_name);
        $urlScr = '/'.$destinationPath . '/' . $file_name;
        return $urlScr;
    }
    public static function stripUnicode($str)
    {
        if (!$str) return false;
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
        );
        foreach ($unicode as $khongdau => $codau) {
            $arr = explode("|", $codau);
            $str = str_replace($arr, $khongdau, $str);
        }
        return $str;
    }
    public static function builtSlug($str)
    {
        $today = date("Y-m-d_H-i-s");
        $str = trim($str);
        if ($str == "") return "post".$today;
        $str = str_replace('"', '', $str);
        $str = str_replace("'", '', $str);
        $str = static::stripUnicode($str);
        $str = mb_convert_case($str, MB_CASE_LOWER, 'utf-8');
        $str = str_replace(' ', '-', $str);
        return $str;
    }
    public static function mail_utf8($to, $from_user, $from_email, $subject = '(No subject)', $message = '')
    {
        $from_user = "=?UTF-8?B?" . base64_encode($from_user) . "?=";
        $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
        $headers = "From: $from_user <$from_email>\r\n" .
            "MIME-Version: 1.0" . "\r\n" .
            "Content-type: text/html; charset=UTF-8" . "\r\n";
        return mail($to, $subject, $message, $headers);
    }
    public static function RandomKey()
    {
        $s = "";
        $m = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j");
        for ($i = 1; $i <= 11; $i++) {
            $r = rand(0, count($m) - 1);
            $s = $s . $m[$r];
        }
        return $s;
    }
    public static function cate_parent($data, $parent = 0, $str = " ", $select = '0', $disableCate = " ")
    {
        foreach ($data as $val) {
            $id = $val->id;
            $name = $val->name;
            if ($val->id_parent == $parent) {
                if ($select != 0 && $id == $select) {
                    echo "<option value='$id' selected>$str $name</option>";
                } else if ($disableCate != " " && $id == $disableCate) {
                    echo "<option value='$id' disabled>$str $name</option>";
                } else {
                    echo "<option value='$id'>$str $name</option>";
                }
                cate_parent($data, $id, $str . "-", $select, $disableCate);
            }
        }
    }
    public static function AvataUser($file, $destination, $overlay = 'images/watermark.png', $X = 0, $Y = 0)
    {
        $watermark = imagecreatefrompng($overlay);
        $source = getimagesize($file);
        $source_mime = $source['mime'];
        $source_x = $source[0];
        $source_y = $source[1];
        if ($source_mime == "image/png") {
            $image = imagecreatefrompng($file);
        } else if ($source_mime == "image/jpeg") {
            $image = imagecreatefromjpeg($file);
        } else if ($source_mime == "image/gif") {
            $image = imagecreatefromgif($file);
        }
        $thumb_width = 500;
        $thumb_height = 500;
        $width = imagesx($image);
        $height = imagesy($image);
        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;
        if ($original_aspect >= $thumb_aspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }
        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
// Resize and crop
        imagecopyresampled($thumb,
            $image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);
//	imagecopy($thumb, $watermark, 500 - 223, 300 - 25, 0, 0, imagesx($watermark), imagesy($watermark));
        imagepng($thumb, $destination);
        imagedestroy($thumb);
        return $destination;
    }
    public static function resizeDrop($file, $destination)
    {
//        $watermark =    imagecreatefrompng($overlay);
        $source = getimagesize($file);
        $source_mime = $source['mime'];
        $source_x = $source[0];
        $source_y = $source[1];
        if ($source_mime == "image/png") {
            $image = imagecreatefrompng($file);
        } else if ($source_mime == "image/jpeg") {
            $image = imagecreatefromjpeg($file);
        } else if ($source_mime == "image/gif") {
            $image = imagecreatefromgif($file);
        }
        $thumb_width = 480;
        $thumb_height = 606;
        $width = imagesx($image);
        $height = imagesy($image);
        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;
        if ($original_aspect >= $thumb_aspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }
        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
// Resize and crop
        imagecopyresampled($thumb,
            $image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);
        imagepng($thumb, $destination);
        imagedestroy($thumb);
        return $destination;
    }
    public static function watermark_image($file, $destination, $overlay = 'images/watermark.png', $X = 0, $Y = 0)
    {
        $watermark = imagecreatefrompng($overlay);
        $source = getimagesize($file);
        $source_mime = $source['mime'];
        $source_x = $source[0];
        $source_y = $source[1];
        if ($source_mime == "image/png") {
            $image = imagecreatefrompng($file);
        } else if ($source_mime == "image/jpeg") {
            $image = imagecreatefromjpeg($file);
        } else if ($source_mime == "image/gif") {
            $image = imagecreatefromgif($file);
        }
        $thumb_width = 500;
        $thumb_height = 300;
        $width = imagesx($image);
        $height = imagesy($image);
        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;
        if ($original_aspect >= $thumb_aspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }
        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
        // Resize and crop
        imagecopyresampled($thumb,
            $image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);
        imagecopy($thumb, $watermark, 500 - 223, 300 - 25, 0, 0, imagesx($watermark), imagesy($watermark));
        imagepng($thumb, $destination);
        imagedestroy($thumb);
        return $destination;
    }
    public static function product_price($priceFloat)
    {
        $symbol = ' VNĐ';
        $symbol_thousand = '.';
        $decimal_place = 0;
        $price = number_format($priceFloat, $decimal_place, '', $symbol_thousand);
        return $price . $symbol;
    }
    public static function _substr($str, $length, $minword = 3)
    {
        $sub = '';
        $len = 0;
        foreach (explode(' ', $str) as $word)
        {
            $part = (($sub != '') ? ' ' : '') . $word;
            $sub .= $part;
            $len += strlen($part);
            if (strlen($word) > $minword && strlen($sub) >= $length)
            {
                break;
            }
        }
        return $sub . (($len < strlen($str)) ? '...' : '');
    }
    public  static function StringExplodeProvince($id)
    {
        $province = Province::where('provinceid',$id)->first();
        $code_provice = "";
        if(count($province) !=0) {
            $code_provice = $province->province_code;
        }
        else{
            $code_provice="XX";
        }
        return $code_provice;
    }
    public  static function StringExplodeCategory($id)
    {
        $category = CategoryProduct::where('id',$id)->first();
        $code_cate = "";
        if(count($category) !=0) {
            $code_cate = $category->cate_code;
            /*$atr = explode(' ', $category->name);
            foreach ($atr as $item) {
                $code_cate = $code_cate . strtoupper($item[0]);
            }*/
        }
        else{
            $code_cate="XX";
        }
        return $code_cate;
    }
    public  static function UserCode($id){
        $userInfo = User::select('users.*','role_user.user_id','role_user.role_id','roles.name as nameRole')
            ->leftJoin('role_user','users.id','=','role_user.user_id')
            ->leftJoin('roles','roles.id','=','role_user.role_id')
            ->where('users.id',$id)
            ->first();
        $code_user ="";
//        dd($userInfo);
        if(count($userInfo)!=0) {
            if ($userInfo->role_id != 4) {
                $id_province = User::where('id', $id)->first();
                $code_1 = strtoupper($userInfo->nameRole);
                $code_2 = Util::StringExplodeProvince($id_province->province);
                $code_3 = $userInfo->id;
                $code_user = $code_1 . "-" . $code_2 . "-" . $code_3;
            } else {
                $id_province = WareHouse::where('user_id', $id)->first();
                $code_1 = strtoupper($userInfo->nameRole);
                $code_2 = Util::StringExplodeProvince($id_province->province);
                $code_3 = $userInfo->id;
                $code_user = $code_1 . "-" . $code_2 . "-" . $code_3;
            }
        }
        else{
            $code_user= "XX";
        }
        return $code_user;
    }
    public  static function ProductCode($id){
        $product = Product::find($id);
        $code_2 = $product->kho;
        $code_1 = Util::StringExplodeCategory($product->category);
        $code_3 = $product->id;
        $code_product = $code_1."-".$code_2."-".$code_3;
        return $code_product;
    }
    public  static function OrderCode($id){
        $order = Order::find($id);
        $user = User::find($order->customer_id);
        $code_2 = $order->kho_id;
        $code_1 = Util::StringExplodeProvince($user->province);
        $code_3 = $order->id;
        $code_order = $code_1."-".$code_2."-".$code_3;
        return $code_order;
    }
    public static function FormatMoney($strMoney) {
        $unit=array('VNĐ','VNĐ','triệu(VNĐ) ','tỉ(VNĐ)','nghìn tỉ(VNĐ)','triệu tỉ(VNĐ)','tỉ tỉ(VNĐ)');
        $len = strlen($strMoney);
        if ($len > 6) {
            $money = $strMoney/pow(1000,($i=floor(log($strMoney,1000))));
            if(is_int($money)){ 
                return $money.' '.$unit[$i]; 
            } else { 
                return number_format($money,2).' <span class="unit ">'.$unit[$i] .'</span>'; 
            }
        }
        else {
            return number_format($strMoney).'<span class="unit "> VNĐ </span>';
        }
    }
    public static function DayJoinGroup($created) {
        $timeNow = date("Y-m-d H:i:s");
        $dteStart = new DateTime($timeNow);
        $dteEnd   = new DateTime($created);
        $dteDiff  = $dteStart->diff($dteEnd);
        $dateJoin = ($dteDiff->format('%a'));
        return $dateJoin;
    }
    public static function CheckRoleUserViewInfo($strUID) {
        $user = User::leftjoin('role_user','role_user.user_id','=','users.id')
            ->where('user_id', $strUID)->first();
        return $user->role_id;    
    }
    public static function getIdUserOfRole ($roleID) {
        $user = User::leftjoin('role_user','role_user.user_id','=','users.id')
                ->where('role_user.role_id', $roleID)->get();
        foreach ($user as $itemUser) {
            $userID[] = $itemUser->id;
        }
        return $userID;
    }
    public static function getDateNowVN () {
        $tdate = date("d");
        $tmonth = date("m");
        $tyear = date("Y");
        return "Ngày " .$tdate. " tháng " .$tmonth. " năm " .$tyear;
    }
    public static $dictionnaryNumbers = array(
        0 => "không",
        1 => "một",
        2 => "hai",
        3 => "ba",
        4 => "bốn",
        5 => "năm",
        6 => "sáu",
        7 => "bảy",
        8 => "tám",
        9 => "chín",
    );

    public static $dictionnaryUnits = array(
        0 => "tỷ",      
        1 => "triệu",       
        2 => "nghìn",       
        3 => "đồng",        
    );

    public static function readNumber3Digits($number, $dictionnaryNumbers, $readFull = true){
        
            // 01 - LẤY CHỮ SỐ HÀNG TRĂM, HÀNG CHỤC, HÀNG ĐƠN VỊ
        $number     = strval($number);
        $number     = str_pad($number, 3, 0, STR_PAD_LEFT);
        $digit_0    = substr($number, 2, 1);
        $digit_00   = substr($number, 1, 1);
        $digit_000  = substr($number, 0, 1);
        
        // 02 - HÀNG TRĂM
        $str_000 = static::$dictionnaryNumbers[$digit_000] . " trăm ";
        
        // 03 - HÀNG CHỤC
        $str_00 = static::$dictionnaryNumbers[$digit_00] . " mươi ";
        if($digit_00 == 0) $str_00 = " linh ";
        if($digit_00 == 1) $str_00 = " mười ";
            
            // 04 - HÀNG ĐƠN VỊ
        $str_0 = static::$dictionnaryNumbers[$digit_0];
        if($digit_00 > 1 && $digit_0 == 1) $str_0 = " mốt ";
        if($digit_00 > 0 && $digit_0 == 5) $str_0 = " lăm ";
        if($digit_00 == 0 && $digit_0 == 0){
                $str_0  = "";
                $str_00 = "";
        }
    
        if($digit_0 == 0){
                $str_0  = "";
        }
    
        if($readFull == false){
                if($digit_000 == 0) $str_000 = "";
                if($digit_000 == 0 && $digit_00 == 0) $str_00 = "";
        }
    
        $result = $str_000 . $str_00 . $str_0;
    
        return $result;
    }

    public static function formatString($str, $type = null){
        // Dua tat ca cac ky tu ve dang chu thuong
        $str    = strtolower($str);

        // Loai bo khoang trang dau va cuoi chuoi
        $str    = trim($str);

        // Loai bo khoang trang du thua giua cac tu

        $array  = explode(" ", $str);
        foreach($array as $key => $value){
            if(trim($value) == null) {
                    unset($array[$key]);
                    continue;
            }
        
            // Xu ly cho danh tu
            if($type=="danh-tu") {
                    $array[$key] = ucfirst($value);
            }
        }

        $result = implode(" ", $array);

        // Chuyen ky tu dau tien thanh chu hoa
        $result = ucfirst($result);

        return $result;
    }

    public static function readMoneyVN($number){
        $number     = strval($number);
        $number     = str_pad($number, 12, 0, STR_PAD_LEFT);
        $arrNumber  = str_split($number, 3);
    
        foreach($arrNumber as $key => $value){
            if($value != "000"){
                    $index = $key;
                    break;
            }
        }
        foreach($arrNumber as $key => $value){
            if($key >= $index){
                $readFull = true;
                if($key >= $index) $readFull = false;
                $result[$key] = Util::readNumber3Digits($value, (static::$dictionnaryNumbers), $readFull) . " " . (static::$dictionnaryUnits[$key]);
            }
        }
        $result = implode(" ", $result);
        $result = Util::formatString($result);
    
    //      $result = str_replace("không đồng", "đồng", $result);
    //      $result = str_replace("không trăm đồng", "đồng", $result);
    //      $result = str_replace("không nghìn đồng", "đồng", $result);
    //      $result = str_replace("không trăm nghìn đồng", "đồng", $result);
        $result = str_replace("triệu nghìn đồng", "triệu đồng", $result);
        $result = str_replace("tỷ triệu đồng", "tỷ đồng", $result);
        return $result;
    }
}
