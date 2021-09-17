@extends('layouts.default')


@section('content')

<div class="card-view-basket loading-skeleton row">
  <div class="col-sm-6 col-6">
    <div class="card">
      
      <div class="card-body">
        <h2>Thank you @auth {{ auth()->user()->name }} @endauth</h2>

        <h3>Order confirmed !!</h3>
        <header><strong>คำสั่งซื้อหมายเลข</strong> #{{ $payment->docno }}</header>
      </div> <!-- card body -->
    </div><!-- // card -->

    <div class="card">
      <div class="card-body">
        <h2>Customer Information</h2>
        
        <h3>Contact information</h3>
        <p class="card-text">
          {{ $payment->customer_email ? $payment->customer_email : '-' }}
        </p>
        <p class="card-text">
          {{ $payment->tel ? $payment->tel : '-' }}
        </p>
      </div> <!-- card body -->
    </div><!-- // card -->
  </div>
  <div class="col-sm-6 col-6">
    @foreach ($order_items as $item)
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
  </div> <!-- end col-6 -->
</div>
@endsection

@section('script')
<script type="text/javascript" src="{{ url('js/thankyou.js') }}"></script>
@endsection