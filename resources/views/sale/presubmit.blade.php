@extends('layouts.default')


@section('content')

@if (count($basket) > 0)
<div class="card-view-basket loading-skeleton">
  <div class="card card-total-basket">
    <div class="card-body">
      <p class="card-text">สินค้าทั้งหมด {{ $basket[0]->sum_quantity }} รายการ</p>
    </div>
  </div>

  @foreach ($basket_items as $item)
    <div class="card card-basket-item">
      <div class="card-body">
        <div class="basket-item-group">
          <div class="product-thumbnail">
            <img src="{{ $item->img_path }}" 
            class="img-fluid img-thumbnail" alt="{{ $item->title }}" style="max-width: 150px">
          </div>
          <div class="product-title">
            <p class="card-text text-wrap-ellipsis">{{ $item->title }}</p>
          </div>
          <div class="product-grand-amount text-center">
            <span>
              {{ number_format($item->grand_amount) }} บาท
            </span>
            
          </div>
          <div class="adjust-quantity-input">
            <section class="">
              <div class="d-inine-block text-center">{{ $item->quantity }} {{ $item->unit_name }}</div>
            </section>
          </div>
        </div>
      </div>
    </div>
  @endforeach  

  <div class="card card-total-basket">
    <div class="card-body">
      <div class="card-basket-summary">
        <div class="basket-summary">
          <span class="">
            <strong>ยอดรวม</strong>
          </span>
          <span class="">
            {{ number_format($basket[0]->sum_grand_amount, 2) }} บาท
          </span>
        </div>
        
        <div class="basket-summary">
          <span class="">
            <strong>ส่วนลด</strong>
          </span>
          <span class="">
            {{ number_format($basket[0]->sum_discount_amount, 2) }} บาท
          </span>
        </div>

        <div class="basket-summary">
          <span class="">
            <strong>ยอดรวมทั้งสิ้น</strong>
          </span>
          <span class="">
            {{ number_format($basket[0]->sum_net_amount, 2) }} บาท
          </span>
        </div>
      </div>      
    </div>
  </div>

  @foreach ($customer_address as $item)
    <div class="card bt-5">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-11">
            <div class="card-text">
              <input type="hidden" value="{{ $item->customer_address_id }}" id="customer_address_id" />
              <header class="d-block">
                <h4>{{ $item->name}}</h4>
              </header>
                <section class="d-block">
                  <h5><strong>ที่อยู่ที่จัดส่ง: </strong></h5>{{ $item->address_1 }} {{ $item->address_2 }} {{$item->subdistrict_name}} {{$item->district_name}}
                  {{$item->province_name}} {{$item->zipcode}} 
                  <strong>โทรศัพท์</strong> {{ $item->tel}} <strong>อีเมลล์</strong> {{ $item->email}}
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
 
  <div class="text-center mt-10">
    <button class="btn btn-success" id="make-order-button">ดำเนินการชำระเงิน</button>
  </div>
@else
  <div class="text-center loading-skeleton">
    <p class="card-text">ไม่พบสินค้า</p>

    <div class="mt-10 hidden">
      <button class="btn btn-success" id="make-order-button">ดำเนินการชำระเงิน</button>
    </div>
  </div>

@endif


@endsection

@section('script')
  <script type="text/javascript" src="{{ url('js/presubmit.js') }}"></script>
@endsection