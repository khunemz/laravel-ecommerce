<?php

namespace App\Models;

use App\Models\BaseRepository;
use Illuminate\Support\Facades\DB;

class SaleRepository extends BaseRepository
{
  public function makeOrder($data)
  {
    $results = DB::insert(@"", []);
    return $results;
  }

  public function addCart($data)
  {
    $results = DB::insert(@"", []);
    return $results;
  }
}
