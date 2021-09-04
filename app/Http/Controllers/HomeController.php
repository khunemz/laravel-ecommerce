<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductRepository;

class HomeController extends Controller
{
  public function index()
  {
    return view('home.index', []);
  }
}
