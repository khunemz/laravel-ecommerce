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
          <span class="d-block">
            Payment Date: {{ $payment->payment_ondate ? $payment->payment_ondate : '-' }}
          </span>
        </p>
        <p class="card-text">
          <span class="d-block">
            Email:  {{ $payment->customer_email ? $payment->customer_email : '-' }}
          </span>
        </p>
        <p class="card-text">
          <span class="d-block">
            Tel: {{ $payment->tel ? $payment->tel : '-' }}
          </span>
        </p>

        <p class="card-text">
          <span class="d-block">
            Address: {{ $payment->address_1 ? $payment->address_1 : '-' }} , 
            {{ $payment->address_2 ? $payment->address_2 : '-' }}
            {{ $payment->subdistrict_name ? 'ตำบล ' .$payment->subdistrict_name : '-' }}
            {{ $payment->district_name ? 'อำเภอ ' .$payment->district_name : '-' }}
            {{ $payment->province_name ? 'จังหวัด ' .$payment->province_name : '-' }}
            {{ $payment->zipcode ? 'รหัสไปรษณีย์ ' .$payment->zipcode : '-' }}
          </span>
        </p>

        <p class="card-text">
          <span class="d-block">
            Payment method: {{ $payment->payment_method_desc ? $payment->payment_method_desc : '-' }} <br />      
            Card no: (Last four digits): {{ $payment->last_4_digits ? '***' .  $payment->last_4_digits : '-' }} , 
          </span>
        </p>
        
        <div class="text-center mt-10">
          <a class="btn btn-success" href="{{ url('/')}}">กลับหน้าหลัก</a>
        </div>
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