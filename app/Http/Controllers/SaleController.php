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
    return $result;
  }
}
