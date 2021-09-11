<?php

namespace App\Models;

use App\Models\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Models\ProductRepository;

class SaleRepository extends BaseRepository
{
  public function addAddress($data)
  {
    $result = false;
    // insert address
    $result= DB::insert(@"
      INSERT INTO ecommerce.addresses
      (
        address_1,
        address_2,
        name, 
        email ,
        tel,
        `type`, 	
        taxno, 
        subdistrict_id, 
        district_id, 
        province_id, 
        zipcode, 
        created_at, created_by, updated_at, updated_by, delflag)
      VALUES(?,?,?,?,?,?,?,?,?,?,?, CURRENT_TIMESTAMP, -1, CURRENT_TIMESTAMP, -1, 0);    
    ", [
      $data['address_1'], 
      $data['address_2'],
      $data['name'],
      $data['email'],
      $data['tel'],
      $data['type'],
      $data['taxno'],
      $data['subdistrict_id'],
      $data['district_id'],
      $data['province_id'],
      $data['zipcode'],
      $data['customer_id'],
    ]);

    $id = DB::getPdo()->lastInsertId();

    // find exsiting

    $customser_address = DB::table('customer_address')->where([
      ['address_id', $id], 
      ['customer_id', $data['customer_id']]
    ])->first();
    // insert customer address

    $is_default = 0;
    $order_rank = 1;
    if($customser_address == null) {
      $is_default = 1;
    } else {
      $order_rank = $customser_address->order_rank + 1;
    }

    $result= DB::insert(@"
    INSERT INTO ecommerce.customer_address
    (
      address_id, 
      customer_id, 
      `type`, 
      is_default, 
      order_rank, 
      created_at, created_by, updated_at, updated_by, delflag
    )
    VALUES(?, ?, ?, ?, ?, CURRENT_TIMESTAMP, -1, CURRENT_TIMESTAMP, -1, 0);

    ", [
      $id, $data['customer_id'], $data['type'], $is_default, $order_rank
    ]);

    $id = DB::getPdo()->lastInsertId();

    return $id;
  }

  public function deleteBasketItem($id)
  {
    $result = DB::delete(@"DELETE FROM ecommerce.basket_items WHERE id=?;", [$id]);
    return $result;
  }

  public function getBasketItems($customer_id) {
    $results = DB::select(@"
    SELECT 
        bi.id, 
        p.id as product_id,
        p.product_code , 
        p.title, 
        p.img_path,
        p.description ,
        bi.quantity ,
        u.name as unit_name,
        bi.price , 
        bi.grand_amount , 
        bi.discount_amount , 
        bi.tax_amount , 
        bi.net_amount 
    from basket_items bi 
    inner join products p on bi.product_id = p.id 
    inner join units u on u.id  = bi.unit_Id 
    where p.delflag = 0 
      and u.delflag  = 0 
      and bi.delflag  = 0 
      and customer_id = ?
    ", [$customer_id]);
    return $results;
  }

  public function getBasket($customer_id) {
    $results = DB::select(@"
    select 
    bi.customer_id , 
      sum(bi.quantity) as sum_quantity, 
      sum(bi.grand_amount) as sum_grand_amount, 
      sum(bi.tax_amount) as sum_tax_amount, 
      sum(bi.discount_amount) as sum_discount_amount, 
      sum(bi.net_amount) as sum_net_amount 
    from basket_items bi 
    where bi.delflag = 0 and bi.customer_id = ? and bi.status = 0
    group by bi.customer_id 
    ", [$customer_id]);
    return $results;
  }


  public function addCart($data)
  {
    $product_repo = new ProductRepository();
    $product_id = $data['product_id'];
    $quantity = $data['quantity'];
    $product =  $product_repo->findProduct($product_id)[0];
    $unit_id = $product->unit_id;
    $price = $product->price;
    $grand_amount = $quantity * $price;
    $discount_amount = 0;
    $customer_id = 1; // todo: make this larter
    $seq_no = 1;
    $taxrate = 0.07;
    $tax_amount = (( $grand_amount - $discount_amount ) *  7) / 107;
    $net_amount = $grand_amount - $discount_amount;    

    // find before if not exist then insert
    $basket_items = $this->findBasketItemByProductId($product_id, $unit_id, $customer_id);
    if(count($basket_items) == 0) {
        // find seq_no
        DB::insert(@"
        INSERT INTO ecommerce.basket_items
          (seq_no, product_id, unit_Id, quantity, price, grand_amount, 
          tax_rate, tax_amount, discount_amount, net_amount, customer_id,status,
          created_at, created_by, updated_at, updated_by, delflag)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?, CURRENT_TIMESTAMP, -1, CURRENT_TIMESTAMP, -1, 0);
      ", [
        $seq_no , $product_id, $unit_id, $quantity, $price, $grand_amount
      , $taxrate, $tax_amount, $discount_amount, $net_amount, $customer_id, 0 
      ]);
    } else {
      $basket_item = $basket_items[0];
      $basket_item_id = $basket_item->id;
      $new_quantity = $basket_item->quantity + $quantity;
      $new_grand_amount = $basket_item->grand_amount + $grand_amount;
      $new_discount_amount = $basket_item->discount_amount + $discount_amount;
      $new_tax_amount = $basket_item->tax_amount + $tax_amount;
      $new_net_amount = $basket_item->net_amount + $net_amount;

      DB::update(@"
      UPDATE ecommerce.basket_items
      SET 
        quantity=?, 
        grand_amount=?, 
        tax_amount=?, 
        discount_amount=?, 
        net_amount=?, 
        updated_at=CURRENT_TIMESTAMP, 
        updated_by=-1 
      WHERE id=?;
      ", [
          $new_quantity, 
          $new_grand_amount, 
          $new_tax_amount, 
          $new_discount_amount, 
          $new_net_amount, 
          $basket_item_id]);

    }
    $total_quantity = $this->getBasketTotalQuantity($customer_id);
    $total_quantity_response = $total_quantity[0]->total_quantity;
    return $total_quantity_response;

  }

  public function findBasketItemByProductId($product_id, $unit_id, $customer_id) {
    $results = DB::select(@"select * from basket_items bi  where product_id  = ? and unit_Id  = ? and customer_id = ? and status = 0 and delflag = 0;",[$product_id, $unit_id,$customer_id]);
    return $results;
  } 
  
  public function getBasketTotalQuantity($customer_id) {
    $results = DB::select(@"select sum(bi.quantity) as total_quantity from basket_items bi  where customer_id = ? and status = 0 and delflag = 0;",[$customer_id]);
    return $results;
  } 

  public function getAddressByCustomerAddressId($customer_address_id) {
    $results = DB::select(@"
    SELECT c.id as customer_id, 
      c.name, 
      c.email , 
      c.tel , 
      ca.id as customer_address_id,
      ca.`type`, 
      ca.is_default,
      a.id  as address_id, 
      a.address_1 , 
      a.address_2 ,
      p.id as province_id , 
      p.name as province_name ,
      d.id as subdistrict_id ,
      d.name as district_name , 
      subd.id as subdistrict_id ,
      subd.name as subdistrict_name ,
      zipcode 
    from addresses a 
      inner join customer_address ca on a.id  = ca.address_id 
      inner join customers c on c.id  = ca.customer_id 
      inner join province p on p.id  = a.province_id 
      inner join district d on d.id  = a.district_id 
      inner join subdistrict subd on subd.id  = a.subdistrict_id 
    where a.delflag = 0 and c.delflag  = 0 and ca.delflag = 0 and ca.id  = ?;
    ",[$customer_address_id]);
    return $results;
  } 


  public function getCustomerAddress($customer_id) {
    $results = DB::select(@"
      SELECT c.id as customer_id, 
        c.name, 
        c.email , 
        c.tel , 
        ca.id as customer_address_id,
        ca.`type`, 
        ca.is_default,
        a.id  as address_id, 
        a.address_1 , 
        a.address_2 ,
        p.id as province_id , 
        p.name as province_name ,
        d.id as subdistrict_id ,
        d.name as district_name , 
        subd.id as subdistrict_id ,
        subd.name as subdistrict_name ,
        zipcode 
      from addresses a 
        inner join customer_address ca on a.id  = ca.address_id 
        inner join customers c on c.id  = ca.customer_id 
        inner join province p on p.id  = a.province_id 
        inner join district d on d.id  = a.district_id 
        inner join subdistrict subd on subd.id  = a.subdistrict_id 
      where a.delflag = 0 and c.delflag  = 0 and ca.delflag = 0 and c.id  = ?;
    ",[$customer_id]);
    return $results;
  } 

  public function updateCart($data) {

    $product_repo = new ProductRepository();
    $product_id = $data['product_id'];
    $quantity = $data['quantity'];
    $product =  $product_repo->findProduct($product_id)[0];
    $price = $product->price;
    $grand_amount = $quantity * $price;
    $discount_amount = 0;  
    $tax_amount = (( $grand_amount - $discount_amount ) *  7) / 107;
    $net_amount = $grand_amount - $discount_amount;    

    $result = DB::update(@"
      UPDATE ecommerce.basket_items
      SET 
        quantity=?, 
        grand_amount=?, 
        tax_amount=?, 
        discount_amount=?, 
        net_amount=?, 
        updated_at=CURRENT_TIMESTAMP, 
        updated_by=-1 
      WHERE id=?;
      ", [
          intval($data['quantity']), 
          $grand_amount, 
          $tax_amount, 
          $discount_amount, 
          $net_amount, 
          intval($data['basket_item_id'])
        ]);
      return $result;
  }

  public function makeOrder($customer_address_id) {
    
  }

  public function getProvince() {
    $results = DB::select(@"
      SELECT  p.id as province_id , p.name as province_name from province p where p.delflag  = 0
    ",[]);
    return $results;
  }

  public function getDistricts($province_id) {
    $results = DB::select(@"
      SELECT  d.id as district_id , d.name as district_name from district d where d.delflag  = 0 and d.province_id = ?
    ",[$province_id]);
    return $results;
  }

  public function getSubDistricts($district_id) {
    $results = DB::select(@"
    SELECT  d.id as subdistrict_id , d.name as subdistrict_name from subdistrict d where d.delflag  = 0 and d.district_id = ?
  ",[$district_id]);
  return $results;
  }
}
