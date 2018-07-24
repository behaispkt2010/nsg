<?php
namespace App\Http\Controllers\Report;

use App\Order;
use App\User;
use App\ProductOrder;
use App\OrderStatus;
use App\HistoryUpdateStatusOrder;
use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Controllers\PDF\PDFController as CommonPdf;
use Request,PDF,PdfMerger;
use DB,Response,App,Session,File,Redirect;

class OrdersController extends PDFController {

 /**
  * Index
  * -----------------------------------------------
  * @author      :   
  * @param       :   null
  * @return      :   null
  * @access      :   public
  * @see         :   remark
  */
	public function getIndex(){
    $arrAllOrders = Order::select('orders.*', 'users.address', 'users.province', 'users.name', 'users.phone_number')
            ->leftJoin('users', 'orders.customer_id', '=', 'users.id')
            ->orderBy('id','DESC')
            ->paginate(9);
    return view('reports.pdf.orders.index',compact('arrAllOrders'));
  }
  public function getOrderDetail($strOID) {

    $productOrder = ProductOrder::select('product_orders.*', 'products.code', 'products.title', 'products.price_out')
        ->leftJoin('products', 'product_orders.id_product', 'products.id')
        ->where('product_orders.order_id', $strOID)->get();
    $orderStatus = OrderStatus::get();
    $historyOrder = HistoryUpdateStatusOrder::select('history_update_status_order.*','order_status.*','users.name as username','users.id as userid')
        ->leftJoin('order_status','history_update_status_order.status','=','order_status.id')
        ->leftJoin('users','users.id','=','history_update_status_order.author_id')
        ->where('history_update_status_order.order_id',$strOID)
        ->orderBy('history_update_status_order.id','DESC')
        ->get();
    $arrOrder = Order::select('orders.*', 'users.address', 'users.province', 'users.name', 'users.phone_number')
        ->leftJoin('users', 'orders.customer_id', '=', 'users.id')
        ->where('orders.id','=', $strOID)
        ->first();
    $arrWareHouse = Order::select('ware_houses.*', 'users.phone_number', 'users.name')
        ->leftJoin('users', 'orders.kho_id', '=', 'users.id')
        ->leftJoin('ware_houses', 'ware_houses.user_id', '=', 'users.id')
        ->where('orders.id','=', $strOID)
        ->first();
    $data = [
      'id' => $strOID,
      'productOrder' => $productOrder,
      'orderStatus' => $orderStatus,
      'historyOrder' => $historyOrder,
      'arrOrder' => $arrOrder,
      'arrWareHouse' => $arrWareHouse,
    ];  
    // dd($arrOrder);      
    return view('reports.pdf.orders.detail', $data);        
  }
  public function getInventoryDeliveryVoucher ($strOID) {  // phiếu xuất kho
    $arrOrder = Order::select('orders.*', 'users.address', 'users.province', 'users.name', 'users.phone_number')
        ->leftJoin('users', 'orders.customer_id', '=', 'users.id')
        ->where('orders.id','=', $strOID)
        ->first();
    $productOrder = ProductOrder::select('product_orders.*', 'products.code', 'products.title', 'products.price_out')
        ->leftJoin('products', 'product_orders.id_product', 'products.id')
        ->where('product_orders.order_id', $strOID)->get(); 
    // dd($productOrder);       
    $data = [
      'id' => $strOID,
      'productOrder' => $productOrder,
      'arrOrder' => $arrOrder,
    ];      
    return view('reports.pdf.orders.inventory_delivery_voucher', $data);
  }

  public function getInventoryReceivingVoucher ($strOID) {  // phiếu nhập kho
    return view('reports.pdf.orders.inventory_receiving_voucher');
  }

  public function getReceiptVoucher($strOID) {   // phiếu thu
    return view('reports.pdf.orders.receipt_voucher');
  }

  public function getPaymentVoucher($strOID) {  // phiếu chi
    return view('reports.pdf.orders.payment_voucher');
  }
}
