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

  public function getBasket($id) {  
    $repo = new SaleRepository();
    $basket = $repo->getBasket($id);
    $basket_items = $repo->getBasketItems($id);
    
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
}
