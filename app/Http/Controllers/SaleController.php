<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductRepository;
use App\Models\SaleRepository;
use Illuminate\Http\Request;

class SaleController extends Controller
{
  public function addCart(Request $request) {
    
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
  }

  public function getBasket($customer_id) {  
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
  }

  public function viewbasket() {
    $customer_id = 1;
    $repo = new SaleRepository();
    $basket = $repo->getBasket($customer_id);
    $basket_items = $repo->getBasketItems($customer_id);
    return view('sale.viewbasket', [
      'basket' => $basket,
      'basket_items' => $basket_items
    ]);
  }

  public function checkout() {
    $customer_id = 1;
    $repo = new SaleRepository();
    $customer_address = $repo->getCustomerAddress($customer_id);
    $repo = new SaleRepository();
    return view('sale.checkout', [
      'customer_address' => $customer_address,
    ]);
  }

  public function getProvinces() {
    $repo = new SaleRepository();
    $provinces = $repo->getProvince();
    return response()->json($provinces);
  }

  public function getDistricts($id) {
    $repo = new SaleRepository();
    $districts = $repo->getDistricts($id);
    return response()->json($districts);
  }

  public function getSubDistricts($id) {
    $repo = new SaleRepository();
    $subdistricts = $repo->getSubDistricts($id);
    return response()->json($subdistricts);
  }

  public function presubmit() {
    $customer_id = 1;
    $repo = new SaleRepository();
    $basket = $repo->getBasket($customer_id);
    $basket_items = $repo->getBasketItems($customer_id);    
    return view('sale.checkout', [
      'basket' => $basket,
      'basket_items' => $basket_items
    ]);
  }

  public function delete($id) {  
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
  }

}
