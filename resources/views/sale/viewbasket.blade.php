@extends('layouts.default')


@section('content')
<div class="card-view-basket loading-skeleton">
  <div class="card card-total-basket">
    <div class="card-body">
      <p class="card-text">สินค้าทั้งหมด 0 รายการ</p>
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
            {{ number_format($item->grand_amount) }} บาท
          </div>
          <div class="adjust-quantity-input">
            <section class="adjust-quantity">
              <button class="btn btn-outline-info d-inline-block" id="decrease-button">-</button>
              <input id="quantity" 
                type="number" 
                class="form-control d-inline-block text-center" 
                placeholder="0.00" 
                min="1" 
                max="999999999" 
                value="{{ $item->quantity }}" />
              <button class="btn btn-outline-info" id="increase-button">+</button>
            </section>
          </div>
        </div>
      </div>
    </div>
  @endforeach  

  <hr />
  <div class="card card-total-basket">
    <div class="card-body">
      <div class="card-basket-summary">
        <div class="basket-summary">
          <span class="">
            ยอดรวม
          </span>
          <span class="">
            {{ number_format($basket[0]->sum_grand_amount, 2) }} บาท
          </span>
        </div>
        
        <div class="basket-summary">
          <span class="">
            ส่วนลด
          </span>
          <span class="">
            {{ number_format($basket[0]->sum_discount_amount, 2) }} บาท
          </span>
        </div>

        <div class="basket-summary">
          <span class="">
            ยอดรวมทั้งสิ้น
          </span>
          <span class="">
            {{ number_format($basket[0]->sum_net_amount, 2) }} บาท
          </span>
        </div>
      </div>

      <div class="payment-button row float-right">
        <div class="d-grid gap-2 col-6 mx-auto">
          <button class="btn btn-success">ดำเนินการชำระเงิน</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
  <script type="text/javascript" src="{{ url('js/viewbasket.js') }}"></script>
@endsection