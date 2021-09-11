<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductRepository;

class HomeController extends Controller
{
  public function index()
  {
    try {
      return view('home.index', []);
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
