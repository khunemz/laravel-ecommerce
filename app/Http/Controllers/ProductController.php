<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class ProductController extends Controller
{
  public function index()
  {
    return view('products.index');
  }
}
