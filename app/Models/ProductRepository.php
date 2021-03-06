<?php

namespace App\Models;

use App\Models\BaseRepository;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository
{
  public function getProducts($page, $limit, $category)
  {
    $offset = ($page - 1) * $limit;
    $results = DB::select(@"
    select 
      p.id, 
      p.product_code, 
      p.title, 
      p.description, 
      p.img_path, 
      p.price, 
      p.sku_id, 
      u.id as unit_id , 
      u.name ,
      IFNULL(cat.id,0) as category_id, 
      IFNULL(cat.name, 'uncategorized') as category_name ,
      count(*) over() as total_count
      from products p inner join units u on p.unit_id  = u.id 
        and p.delflag = 0 and  u.delflag  = 0 
      left join category cat on p.category_id  = cat.id 
        and cat.delflag  = 0
      WHERE (IFNULL(?, 0) = 0 OR cat.id = ?)
      LIMIT ? OFFSET ?
    ", array($category, $category, $limit, $offset));
    return $results;
  }

  public function getCategory() {
    $results = DB::select(@"
      select * from category c 
    ", array());
    return $results;
  }

  public function findProduct($id) {
    $results = DB::select(@"
    select 
      p.id, 
      p.product_code, 
      p.title, 
      p.description, 
      p.img_path, 
      p.price, 
      p.sku_id, 
      u.id as unit_id , 
      u.name ,
      IFNULL(cat.id,0) as category_id, 
      IFNULL(cat.name, 'uncategorized') as category_name ,
      count(*) over() as total_count
      from products p inner join units u on p.unit_id  = u.id 
        and p.delflag = 0 and  u.delflag  = 0 
      left join category cat on p.category_id  = cat.id 
        and cat.delflag  = 0
      WHERE p.id = ?
    ", array($id));
    return $results;
  }

}
