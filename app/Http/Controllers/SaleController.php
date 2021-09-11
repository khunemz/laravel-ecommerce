<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductRepository;
use App\Models\SaleRepository;
use Illuminate\Http\Request;

class SaleController extends Controller
{
  public function addAddress(Request $request)
  {
    return redirect('sale.presubmit');
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
      $repo = new SaleRepository();
      return view('sale.checkout', [
        'customer_address' => $customer_address,
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
