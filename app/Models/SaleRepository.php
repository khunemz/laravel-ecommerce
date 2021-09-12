<?php

namespace App\Models;

use App\Models\BaseRepository;
use Illuminate\Support\Facades\DB;
use App\Models\ProductRepository;

class SaleRepository extends BaseRepository
{

  public function getOrder($order_id) {
    $orderHeader = collect(DB::select(@"
    SELECT 
        id, 
        docno, 
        ondate, 
        status, 
        customer_id, 
        quantity, 
        grand_amount, 
        tax_rate, 
        tax_amount, 
        discount_amount, 
        net_amount,
        customer_address_id
      FROM ecommerce.orders where id = ?;
    ", [$order_id]))->firstOrFail();
    return $orderHeader;
  }

  public function getOrderItem($order_id) {
    $order_items =  DB::select(@"
    SELECT 
        oi.id, 
        p.id as product_id,
        p.product_code , 
        p.title, 
        p.img_path,
        p.description ,
        oi.seq_no,
        oi.quantity ,
        oi.unit_id,
        u.name as unit_name,
        p.price , 
        oi.grand_amount , 
        oi.discount_amount , 
        oi.tax_amount , 
        oi.net_amount 
    from order_items oi inner join orders o on oi.order_id  = o.id 
    inner join products p on oi.product_id = p.id 
    inner join units u on u.id  = oi.unit_Id 
    where p.delflag = 0 
      and u.delflag  = 0 
      and oi.delflag  = 0 
      and o.id  = ?
    ", [$order_id]);
    return $order_items;
  }
  public function addAddress($data)
  {
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

  public function emptyBasket($customer_id) {
    $result = DB::delete(@"DELETE FROM ecommerce.basket_items WHERE customer_id=?;", [$customer_id]);
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
        bi.seq_no,
        bi.quantity ,
        bi.unit_id,
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
    $taxrate = $this->getTaxRate();
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
    // insert sale order by select from basket
    $customer_id = 1;
    
    $basket = collect($this->getBasket($customer_id))->firstOrFail();
    $quantity = $basket->sum_quantity;
    $grand_amount = $basket->sum_grand_amount;
    $tax_amount = $basket->sum_tax_amount;
    $discount_amount = $basket->sum_discount_amount;
    $net_amount = $basket->sum_net_amount;
    $ondate = date('Y-m-d H:i:s');
    $status = 0;
    $taxrate = 0.07;
    $docno = $this->getDocNo();
    /** BASKET */
    $result_order = DB::insert(@"
    INSERT INTO ecommerce.orders
      (
        ondate,docno,status,customer_id, 
        quantity,grand_amount,tax_rate,tax_amount, 
        discount_amount, net_amount, customer_address_id,
        created_at, created_by, updated_at, updated_by, delflag)
    VALUES(
      ?, ?, ?, ?, 
      ?, ?, ?, ?, 
      ?, ?, ?,
      CURRENT_TIMESTAMP, -1, CURRENT_TIMESTAMP, -1, 0);
    ", [
      $ondate, $docno, $status, $customer_id, 
      $quantity,$grand_amount, $taxrate, $tax_amount, 
      $discount_amount,$net_amount, $customer_address_id
    ]);
    $order_id = DB::getPdo()->lastInsertId();


    /** BASKET ITEM */
    $basket_items = $this->getBasketItems($customer_id);
    $tax_rate = $this->getTaxRate();

    foreach ($basket_items as $key => $item) {
      # code...
      $result = DB::insert(@"
      INSERT INTO ecommerce.order_items
        (
          order_id, 
          seq_no, 
          product_id, 
          unit_Id, 
          quantity, 
          tax_rate, 
          tax_amount, 
          discount_amount, 
          net_amount, 
          grand_amount,
          created_at, created_by, updated_at, updated_by, delflag)
          VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, -1, CURRENT_TIMESTAMP, -1, 0);
      ",[$order_id, $item->seq_no,$item->product_id, $item->unit_id, $item->quantity,
        $tax_rate , $item->tax_amount, $item->discount_amount, $item->net_amount , $item->grand_amount   
      ]);
    }
    // delete basket
    $this->emptyBasket($customer_id);
    return $order_id;
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

  public function getDocNo() {
    $row = DB::table('orders')->orderBy('docno', 'desc')->first();
    if ($row) {
      // $docno_int = (int)$row;
      // 2021071800001
      $prev_doc_no = $row->docno;
      // check if it is current year and month
      $prev_running = substr($prev_doc_no, 8);
      $prev_day =  substr($prev_doc_no, 6, 2);
      $prev_month =  substr($prev_doc_no, 4, 2);
      $prev_year = substr($prev_doc_no, 0, 4);

      $prev_date = date("Y-m-d", strtotime($prev_year . "-" . $prev_month . "-" . $prev_day));
      $today = date('Y-m-d');

      $year = date('Y');
      $month = date('m');
      $day = date('d');
      if ($today > $prev_date) {
        $new_running = "000001";
        $docno = $year . $month . $day . $new_running;
      } else {
        $new_running_int = (int)$prev_running + 1;
        $new_running_str = strval($new_running_int);
        $new_running = "";
        if (strlen($new_running_str) == 1) {
          $new_running = "00000" . $new_running_str;
        } else if (strlen($new_running_str) == 2) {
          $new_running = "0000" . $new_running_str;
        } else if (strlen($new_running_str) == 3) {
          $new_running = "000" . $new_running_str;
        } else if (strlen($new_running_str) == 4) {
          $new_running = "00" . $new_running_str;
        } else if (strlen($new_running_str) == 5) {
          $new_running = "0" . $new_running_str;
        } else {
          $new_running = $new_running_str;
        }
        $docno = $prev_year . $prev_month . $prev_day . $new_running;
      }
      return $docno;
    } else {
      $year = date('Y');
      $month = date('m');
      $day = date('d');
      $running = '000001';
      $docno = $year . $month . $day . $running;
      return $docno;
    }
  }

  public function getReceiptNo() {
    $row = DB::table('payments')->orderBy('receiptno', 'desc')->first();
    if ($row) {
      // $docno_int = (int)$row;
      // 2021071800001
      $prev_doc_no = $row->receiptno;
      // check if it is current year and month
      $prev_running = substr($prev_doc_no, 8);
      $prev_day =  substr($prev_doc_no, 6, 2);
      $prev_month =  substr($prev_doc_no, 4, 2);
      $prev_year = substr($prev_doc_no, 0, 4);

      $prev_date = date("Y-m-d", strtotime($prev_year . "-" . $prev_month . "-" . $prev_day));
      $today = date('Y-m-d');

      $year = date('Y');
      $month = date('m');
      $day = date('d');
      if ($today > $prev_date) {
        $new_running = "000001";
        $docno = $year . $month . $day . $new_running;
      } else {
        $new_running_int = (int)$prev_running + 1;
        $new_running_str = strval($new_running_int);
        $new_running = "";
        if (strlen($new_running_str) == 1) {
          $new_running = "00000" . $new_running_str;
        } else if (strlen($new_running_str) == 2) {
          $new_running = "0000" . $new_running_str;
        } else if (strlen($new_running_str) == 3) {
          $new_running = "000" . $new_running_str;
        } else if (strlen($new_running_str) == 4) {
          $new_running = "00" . $new_running_str;
        } else if (strlen($new_running_str) == 5) {
          $new_running = "0" . $new_running_str;
        } else {
          $new_running = $new_running_str;
        }
        $docno = $prev_year . $prev_month . $prev_day . $new_running;
      }
      return $docno;
    } else {
      $year = date('Y');
      $month = date('m');
      $day = date('d');
      $running = '000001';
      $docno = $year . $month . $day . $running;
      return $docno;
    }
  }

  public function insertPayment($payment_data) {

    $order_id = $payment_data['order_id'];
    $ondate = $payment_data['paid_at'];
    $order = $this->getOrder($order_id);
    $payment_type = $this->getPaymentType($payment_data['source_of_fund']);
    $taxrate = $this->getTaxRate();
    $receiptno = $this->getReceiptNo();
    /**
     * 0 init 
     * 1 pending
     * 2 created
     * 3 paid
     * 4 rejected
     * 5 cancel
     */
    $payment_status = 3;
    DB::insert(@"
    INSERT INTO ecommerce.payments
    (
      receiptno, ondate, order_id, status, payment_type, 
      quantity, grand_amount, tax_rate, tax_amount, 
      discount_amount, net_amount, bill_address_id, 
      created_at, created_by, updated_at, updated_by, delflag)
    VALUES(
      ?, ?, ?, ?, ?, 
      ?, ?, ?, ?, 
      ?, ?, ?, 
      CURRENT_TIMESTAMP, -1, CURRENT_TIMESTAMP, -1, 0);
    ", [
      $receiptno, $ondate, $order_id, $payment_status , $payment_type,
      $order->quantity, $order->grand_amount, $taxrate , $order->tax_amount,
      $order->discount_amount, $order->net_amount, $order->customer_address_id  
    ]);

    $payment_id = DB::getPdo()->lastInsertId();
    $payment_vendor_id = $this->getPaymentVendorId($payment_data['vendor_name']);
    DB::insert(@"
    INSERT INTO ecommerce.payments_details
    (
      payment_id, payment_amount, slip_img, payment_token, 
      payment_type_id, payment_vendor_id, 
      created_at, created_by, updated_at, updated_by, delflag)
      VALUES(
        ?, ?, ?, ?, 
        ?, ?, CURRENT_TIMESTAMP, -1, CURRENT_TIMESTAMP, -1, 0);
    ", [$payment_id, $payment_data['amount'], '', $payment_data['transaction_no'],
      $payment_type, $payment_vendor_id, 
    ]);

    DB::update(@"
      UPDATE ecommerce.orders
        SET status = ?, updated_at=CURRENT_TIMESTAMP, updated_by=-1, delflag=0
      WHERE id=?;
    ", [$payment_status , $order_id]);
    return $payment_id;
  }

  public function getPaymentById($payment_id) {
    
    $payment = collect(DB::select(@"
    SELECT p.id as payment_id, p.receiptno, p.ondate as payment_ondate, o.docno,
      o.id as order_id, o.ondate as order_ondate, o.status as order_status, p.status as payment_status,
      p.status, p.payment_type, p.quantity, p.grand_amount, 
      p.tax_rate, p.tax_amount, p.discount_amount, p.net_amount, 
      p.bill_address_id, pd.payment_token, cus.id as customer_id , cus.name as customer_name, 
      ca.id as customer_address_id, adss.id as assress_id, adss.address_1, adss.address_2,
      pv.id as province_id, pv.name as province_name, dt.id as district_id, dt.name as district_name,
      subd.id as subdistrict_id , subd.name as subdistrict_name,
      adss.zipcode ,cus.email as customer_email
    FROM ecommerce.payments p inner join payments_details pd on pd.payment_id = p.id 
    inner join orders o on o.id = p.order_id
    inner join customers cus on cus.id = o.customer_id 
    inner join customer_address ca on ca.customer_id  = cus.id 
    inner join addresses adss on adss.id = ca.address_id 
    inner join province pv on adss.province_id  = pv.id
    inner join district dt on dt.id = adss.district_id 
    inner join subdistrict subd on subd.id = adss.subdistrict_id 
    where p.delflag  = 0 and pd.delflag  = 0 and o.delflag  = 0 
      and cus.delflag  = 0 and ca.delflag  = 0 and adss.delflag  = 0
      and subd.delflag  = 0
      and p.id  = ?
    ", [
      $payment_id
    ]))->firstOrFail();
    return $payment;
  }
  
  public function getPaymentType($source_of_found) {
    if($source_of_found == "card") {
      return 2;
    } else {
      return 1;
    }
  }

  public function getTaxRate() {
    // todo: create table and select from table instead
    return 0.07;
  }

  public function getPaymentVendorId($vendor_name) {
    // todo: create table and select from table instead
    if($vendor_name == "omise") {
      return 2;
    } else {
      return 1;
    }
  }
}
