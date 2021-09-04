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

  public function getProducts($page , $limit, $category) {
    $pRepo = new ProductRepository();
    $result = $pRepo->getProducts($page, $limit, $category);
    return $result;
  }
  public function getCategory() {
    $pRepo = new ProductRepository();
    $result = $pRepo->getCategory();
    return $result;
  }

  public function view($id) {
    $pRepo = new ProductRepository();
    $result = $pRepo->findProduct($id);
    return view('products.view', ['products' => $result]);
  }
}
