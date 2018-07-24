<?php
namespace App\Http\Controllers\Report;

use App\Order;
use App\User;
use App\ProductOrder;
use App\OrderStatus;
use App\HistoryUpdateStatusOrder;
use App\Product;
use App\ProductUpdatePrice;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PDF\PDFController as CommonPdf;
use Request,PDF,PdfMerger;
use DB,Response,App,Session,File,Redirect;
use Illuminate\Support\Facades\Auth;

class ProductController extends PDFController {

 /**
  * Index
  * -----------------------------------------------
  * @author      :   
  * @param       :   null
  * @return      :   null
  * @access      :   public
  * @see         :   remark
  */
	public function getHistoryInput($date){
    if ( Auth::user()->hasRole(['admin','editor']) ) {
        $productUpdatePrice=ProductUpdatePrice::where(DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),$date)
            ->orderBy('id','DESC')
            ->get();
    } else {
        $productUpdatePrice=ProductUpdatePrice::select('product_update_prices.*')
            ->where(DB::raw("(DATE_FORMAT(product_update_prices.created_at,'%d-%m-%Y'))"),$date)
            ->leftjoin('products','products.id','=','product_update_prices.product_id')
            ->where('products.kho', $user_id)
            ->orderBy('id','DESC')
            ->get();
    }
    $data = [
      'date' => $date,
      'productUpdatePrice' => $productUpdatePrice
    ];
    return view('reports.pdf.product.historyInput', $data);
  }
}
