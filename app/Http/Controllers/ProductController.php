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

  public function getProducts($page, $limit, $category)
  {
    try {
      $pRepo = new ProductRepository();
      $result = $pRepo->getProducts($page, $limit, $category);
      return $result;
    } catch (\Throwable $th) {
      throw $th;
    }
  }
  public function getCategory()
  {
    try {
      $pRepo = new ProductRepository();
      $result = $pRepo->getCategory();
      return $result;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function view($id)
  {
    try {
      $pRepo = new ProductRepository();
      $result = $pRepo->findProduct($id);
      return view('products.view', ['products' => $result]);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
