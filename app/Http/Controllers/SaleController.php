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
    $address_1 = $request->input('address_1');
    $address_2 = $request->input('address_2');
    $address_1 = $request->input('address_1');

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
      $address_1 = $request->old('address_1');
      
      return redirect('sale/checkout')
        ->withErrors($validator)
        ->withInput();
    } else {
      return redirect()->action([SaleController::class, 'presubmit']);
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

  public function presubmit()
  {
    try {
      $customer_id = 1;
      $repo = new SaleRepository();
      $basket = $repo->getBasket($customer_id);
      $basket_items = $repo->getBasketItems($customer_id);
      return view('sale.presubmit', [
        'basket' => $basket,
        'basket_items' => $basket_items
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
