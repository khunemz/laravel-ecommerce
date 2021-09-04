<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductRepository;

class HomeController extends Controller
{
  public function index()
  {
    $repo = new ProductRepository();
    $products = $repo->getProducts();
    return view('home.index', ['products' => $products]);
  }
}
