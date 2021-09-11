@extends('layouts.default')


@section('content')

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="confirmModalLabel">
          ลบรายการออกจากรถเข็น
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        คุณต้องการที่จะลบรายการสินค้าชิ้นนี้ใช่หรือไม่?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        <button type="button" class="btn btn-outline-primary confirm-button">ยืนยัน</button>
      </div>
    </div>
  </div>
</div>

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
            <span class="trash-icon delete-button" data-id={{ $item->id }}>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
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
 
  <div class="card bt-5">
    <div class="card-body">
      <div class="payment-button row float-right">
        <div class="d-grid gap-2 col-6 mx-auto">
          <a class="btn btn-success" href="{{url('sale/checkout')}}">ดำเนินการชำระเงิน</a>
        </div>
      </div>
    </div>
  </div>
@else
  <div class="text-center">
    <p class="card-text">ไม่พบสินค้า</p>
  </div>
@endif


@endsection

@section('script')
  <script type="text/javascript" src="{{ url('js/viewbasket.js') }}"></script>
@endsection