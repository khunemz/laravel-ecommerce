<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductRepository;

class ProductController extends Controller
{
  public function index()
  {
    return view('products.index');
  }

  public function getProducts() {
    $pRepo = new ProductRepository();
    $result = $pRepo->getProducts();
    return $result;
  }
  public function getCategory() {
    $pRepo = new ProductRepository();
    $result = $pRepo->getCategory();
    return $result;
  }
}
