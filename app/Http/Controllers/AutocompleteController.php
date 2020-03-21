<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use DB;
use Illuminate\Support\Facades\Input;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\supplier;
use App\processingunit;

class AutocompleteController extends Controller
{
	public function enterbarcode(Request $request){
		$product 	= DB::table('product')->where('product_code',$request->input('barcode'))->first();
		$results[] = [
			'id'			=>$product->product_id,
			'code'			=>$product->product_code,
			'name'			=>$product->product_name,
			'price'			=>$product->product_price,
			'unit'			=>$product->product_unit,
		];
		
		return Response::json(['results' => $results]);
	}
	
	public function enterproduct(Request $request){
		$product 	= DB::table('product')->where('product_id',$request->input('productid'))->first();
		$results[] = [
			'id'			=>$product->product_id,
			'code'			=>$product->product_code,
			'name'			=>$product->product_name,
			'price'			=>$product->product_price,
			'unit'			=>$product->product_unit,
		];
		return Response::json(['results' => $results]);
	}
	
	public function autocompleteproductname(){
		$term = Input::get('term');
		$results = array();
		$query = DB::table('product')->where('product_name', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$results[] = [ 
					'id' 			=> $rs->product_id, 
					'value' 		=> $rs->product_name,
					'barcode' 		=> $rs->product_code,
					'label' 		=> $rs->product_code." / ".$rs->product_name,
					'qty'			=> $rs->product_qty,
					'unit'			=> $rs->product_unit,
					'attrs'			=> $rs->product_name
				];
			}
		}
		return Response::json($results);
	}
	
	public function searchcustomername(){
		$term = Input::get('term');
		$results = array();
		$query = DB::table('customer')->where('customer_name', 'LIKE', '%'.$term.'%')->Orwhere('customer_code', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$addr 		= "";
				$zipcode 	= "";
				if(!empty($rs->customer_detail)){
					$addr 	= "ที่อยู่ :  ".$rs->customer_detail;
					$str 	= explode(' ',$rs->customer_detail);
					if($str){
						foreach($str as $ar){
							if(is_numeric(intval($ar)) && strlen(intval($ar)) == 5){
								$zipcode = $ar;
							}
						}
					}
				}
				
				$results[] = [
					'value' 		=> $rs->customer_name,
					'label' 		=> $rs->customer_name,
					'idcus'			=> $rs->customer_id,
					'tel'			=> $rs->customer_tel,
					'fax'			=> $rs->customer_fax,
					'email'			=> $rs->customer_email,
					'credit'		=> $rs->customer_credit,
					'note'			=> $rs->customer_note,
					'addr'			=> $rs->customer_detail,
					'addrdoc'		=> $rs->customer_detaildoc,
					'zipcode'		=> $zipcode,
					'attr'			=> $addr." โทร :  ".$rs->customer_tel.",  อีเมลล์ :  ".$rs->customer_email
				];
			}
		}
		
		return Response::json($results);
	}
	
	public function searchcustomertel(){
		$term = Input::get('term');
		$results = array();
		$query = DB::table('customer')->where('customer_tel', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$addr = "";
				$zipcode 	= "";
				if(!empty($rs->customer_detail)){
					$addr = "ที่อยู่ :  ".$rs->customer_detail;
					$str 	= explode(' ',$rs->customer_detail);
					if($str){
						foreach($str as $ar){
							if(is_numeric($ar) && strlen($ar) == 5){
								$zipcode = $ar;
							}
						}
					}
				}
				
				$results[] = [
					'value' 		=> $rs->customer_tel,
					'name' 			=> $rs->customer_name,
					'label' 		=> $rs->customer_name,
					'idcus'			=> $rs->customer_id,
					'tel'			=> $rs->customer_tel,
					'note'			=> $rs->customer_note,
					'addr'			=> $rs->customer_detail,
					'addrdoc'		=> $rs->customer_detaildoc,
					'zipcode'		=> $zipcode,
					'attr'			=> $addr." โทร :  ".$rs->customer_tel.",  อีเมลล์ :  ".$rs->customer_email
				];
			}
		}
		
		return Response::json($results);
	}
	
	public function searchcustomertax(){
		$term = Input::get('term');
		$results = array();
		$query = DB::table('customer')->where('customer_idtax', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$addr = "";
				if(!empty($rs->customer_detail)){
					$addr = "ที่อยู่ :  ".$rs->customer_detail;
				}
				
				$results[] = [
					'value' 		=> $rs->customer_idtax,
					'idcus'			=> $rs->customer_id,
					'label' 		=> $rs->customer_name." / ".$rs->customer_idtax,
					'name'			=> $rs->customer_name,
					'tel'			=> $rs->customer_tel,
					'note'			=> $rs->customer_note,
					'addr'			=> $rs->customer_detail,
					'addrdoc'		=> $rs->customer_detaildoc,
					'attr'			=> $addr." โทร :  ".$rs->customer_tel.",  อีเมลล์ :  ".$rs->customer_email
				];
			}
		}
		
		return Response::json($results);
	}
    
	public function searchexpenses(){
		$term 	= Input::get('term');
		$query 	= DB::table('autocomplete')->where('auto_name', 'LIKE', '%'.$term.'%')->get();
		return Response::json($query);
	}
	
    public function searchsupplier(){
        $term = Input::get('term');
		$results = array();
		$query = supplier::where('supplier_name', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$addr = "";
				if(!empty($rs->supplier_address)){
					$addr = "ที่อยู่ :  ".$rs->supplier_address;
				}
				
				$results[] = [
					'tax' 		=> $rs->supplier_tax,
					'id'			=> $rs->supplier_id,
					'label' 		=> $rs->supplier_name." / ".$rs->supplier_tax,
					'name'			=> $rs->supplier_name,
					'tel'			=> $rs->supplier_tel,
					'email'			=> $rs->supplier_email,
					'addr'			=> $rs->supplier_address,
					'attr'			=> $addr." โทร :  ".$rs->supplier_tel.",  อีเมลล์ :  ".$rs->supplier_email
				];
			}
		}
		
		return Response::json($results);
    }
    
    public function searchsuppliertax(){
        $term = Input::get('term');
		$results = array();
		$query = supplier::where('supplier_tax', 'LIKE', '%'.$term.'%')->get();
		if($query){
			foreach ($query as $rs){
				$addr = "";
				if(!empty($rs->supplier_address)){
					$addr = "ที่อยู่ :  ".$rs->supplier_address;
				}
				
				$results[] = [
					'tax' 		    => $rs->supplier_tax,
					'id'			=> $rs->supplier_id,
					'label' 		=> $rs->supplier_name." / ".$rs->supplier_tax,
					'name'			=> $rs->supplier_name,
					'tel'			=> $rs->supplier_tel,
					'email'			=> $rs->supplier_email,
					'addr'			=> $rs->supplier_address,
					'attr'			=> $addr." โทร :  ".$rs->supplier_tel.",  อีเมลล์ :  ".$rs->supplier_email
				];
			}
		}
		
		return Response::json($results);
    }
    
    public function enterimportproduct(Request $request){
        $product = DB::table('product')->where('product_id',$request->input('id'))->first();
        
        $results[] = [
            'pro_id'          =>$product->product_id,
            'pro_code'        =>$product->product_code.'<input type="hidden" name="proid[]" value="'.$product->product_id.'">',
            'pro_name'        =>$product->product_name ,
            'amount'          =>'<input type="text" name="amount[]" value="1" class="form-control onlynumber">'
        ];
		return Response::json(['results' => $results]);
	}
    
    public function enterimportbarcodeproduct(Request $request){
        $product = DB::table('product')->where('product_code',$request->input('barcode'))->first();
        
        $results[] = [
            'pro_id'          =>$product->product_id,
            'pro_code'        =>$product->product_code.'<input type="hidden" name="proid[]" value="'.$product->product_id.'">',
            'pro_name'        =>$product->product_name ,
            'amount'          =>'<input type="text" name="amount[]" value="1" class="form-control onlynumber">'
        ];
		return Response::json(['results' => $results]);
    }
}
