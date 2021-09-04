<?php

namespace App\Models;

use App\Models\BaseRepository;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository
{
  public function getProducts()
  {
    $results = DB::select('select * from products where id = ?', array(1));
    return $results;
  }
}
