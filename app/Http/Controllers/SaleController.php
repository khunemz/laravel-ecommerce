<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductRepository;
use App\Models\SaleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class SaleController extends Controller
{
  public function addAddress(Request $request)
  {    

    $validator = Validator::make($request->all(), [
      'address_1' => 'required|max:150',
      'address_2' => 'max:150',
      'name' => 'required|max:150',
      'email' => 'required|email|max:150',
      'tel' => 'max:20',
      'type' => 'required|numeric',
      'taxno' => 'max:20',
      'subdistrict_id' => 'required|numeric',
      'district_id' => 'required|numeric',
      'province_id' => 'required|numeric',
      'zipcode' => 'required|max:20',
    ]);

    
    if ($validator->fails()) {
      $errors = $validator->errors();   
      return redirect('sale/checkout')
        ->withErrors($validator)
        ->withInput();
    } else {
      $address_1 = $request->input('address_1');
      $address_2 = $request->input('address_2');
      $name = $request->input('name');
      $email = $request->input('email');
      $tel = $request->input('tel');
      $type = $request->input('type');
      $taxno = $request->input('taxno');
      $subdistrict_id = $request->input('subdistrict_id');
      $district_id = $request->input('district_id');
      $province_id = $request->input('province_id');
      $zipcode = $request->input('zipcode');
  
      $data['address_1']    = $address_1;
      $data['address_2']    = $address_2;
      $data['name']         = $name;
      $data['email']        = $email;
      $data['tel']          = $tel;
      $data['type']         = $type;
      $data['taxno']        = $taxno;
      $data['subdistrict_id'] = $subdistrict_id;
      $data['district_id']  = $district_id;
      $data['province_id']  = $province_id;
      $data['zipcode']      = $zipcode;
      $data['customer_id']      = 1;
      $repo = new SaleRepository();
      $customer_address_id = $repo->addAddress($data);
      return redirect()->to(['sale/presubmit/'. $customer_address_id]);
    }
  }
  public function addCart(Request $request)
  {
    try {
      $product_id = $request->input('product_id');
      $quantity = $request->input('quantity');
      $data['product_id'] = $product_id;
      $data['quantity'] = $quantity;

      $repo = new SaleRepository();
      $result = $repo->addCart($data);
      $response = [
        'status' => 201,
        'message' => 'success',
        'data' => [
          'total_quantity' => $result
        ]
      ];
      return response()->json($response);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function updateCart(Request $request)
  {
    try {
      $basket_item_id = $request->input('basket_item_id');
      $product_id = $request->input('product_id');
      $quantity = $request->input('quantity');
      $data['product_id'] = $product_id;
      $data['quantity'] = $quantity;
      $data['basket_item_id'] = $basket_item_id;
      $repo = new SaleRepository();
      $result = $repo->updateCart($data);
      $response = [
        'status' => 201,
        'message' => 'success',
        'data' => [
          'total_quantity' => $result
        ]
      ];
      return response()->json($response);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function processorder() {
    try {
      $customer_address_id = $request->input('customer_address_id');
      $repo = new SaleRepository();
      $result =  $repo->makeOrder($customer_address_id);
      $response = [
        'status' => 201,
        'message' => 'success',
        'data' => [
          'result' => $result
        ]
      ];
      return response()->json($response);
    } catch (\Throwable $th) {
      //throw $th;
    }
  }

  public function getBasket($customer_id)
  {
    try {
      $repo = new SaleRepository();
      $basket = $repo->getBasket($customer_id);
      $basket_items = $repo->getBasketItems($customer_id);

      $response = [
        'status' => 201,
        'message' => 'success',
        'data' => [
          'basket' => $basket,
          'basket_items' => $basket_items
        ]
      ];
      return response()->json($response);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function viewbasket()
  {
    try {
      $customer_id = 1;
      $repo = new SaleRepository();
      $basket = $repo->getBasket($customer_id);
      $basket_items = $repo->getBasketItems($customer_id);
      return view('sale.viewbasket', [
        'basket' => $basket,
        'basket_items' => $basket_items
      ]);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function checkout()
  {
    try {
      $customer_id = 1;
      $repo = new SaleRepository();
      $customer_address = $repo->getCustomerAddress($customer_id);
      $types = [
        ["value" => 1, "text" => "บ้าน"], 
        ["value" => 2, "text" => "ที่ทำงาน"]
      ];  
      return view('sale.checkout', [
        'customer_address' => $customer_address,
        'types' => $types
      ]);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getProvinces()
  {
    try {
      $repo = new SaleRepository();
      $provinces = $repo->getProvince();
      return response()->json($provinces);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getDistricts($id)
  {
    try {
      $repo = new SaleRepository();
      $districts = $repo->getDistricts($id);
      return response()->json($districts);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getSubDistricts($id)
  {
    try {
      $repo = new SaleRepository();
      $subdistricts = $repo->getSubDistricts($id);
      return response()->json($subdistricts);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function presubmit($id)
  {
    try {
      $customer_id = 1;
      $customer_address_id = $id;
      $repo = new SaleRepository();
      $basket = $repo->getBasket($customer_id);
      $basket_items = $repo->getBasketItems($customer_id);
      $customer_address = $repo->getAddressByCustomerAddressId($customer_address_id);
      return view('sale.presubmit', [
        'basket' => $basket,
        'basket_items' => $basket_items,
        'customer_address' => $customer_address,
      ]);
    } catch (\Throwable $th) {
    }
  }

  public function delete($id)
  {
    try {
      $repo = new SaleRepository();
      $result = $repo->deleteBasketItem($id);
      $response = [
        'status' => 201,
        'message' => 'success',
        'data' => [
          'result' => $result,
        ]
      ];
      return response()->json($response);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
