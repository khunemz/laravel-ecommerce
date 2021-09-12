<?php

namespace App\Models;

use App\Models\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Models\ProductRepository;

class CustomerRepository extends BaseRepository
{

  public function createCustomer($user) {
    $user_id = $user->id;
    $username = $user->name;
    $email = $user->email;
    $result = DB::insert(@"
    INSERT INTO ecommerce.customers
    (code, name, email, tel, `type`, order_rank, created_at, created_by, updated_at, updated_by, delflag)
    VALUES(?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, -1, CURRENT_TIMESTAMP, -1, 0);
    ", [strval($user_id), $username, $email, '', 1, $user_id]);
    return $result;
  }

  public function findCustomerByUserId($user_id) {
    $customer_user = collect(DB::select(@"
    SELECT c.id as customer_id, c.name as customer_name, c.code  as customer_code ,
      c.email as customer_email, c.tel as customer_tel,
      u.id as user_id , u.name  as username, u.email as user_email
      from customers c 
    inner join users u  on c.user_id = u.id where u.id  = ?
    ", [$user_id]))->first();
    return $customer_user;
  }
}
