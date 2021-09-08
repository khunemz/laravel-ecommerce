@extends('layouts.default')


@section('content')
<div class="card-view-basket loading-skeleton">
  <div class="card">
    <div class="card-body">
      <p class="card-text">
        {{count($customer_address) == 0 ? "เพิ่มที่อยู่จัดส่ง" : "เลือกที่อยู่จัดส่ง"}}
      </p>
    </div>
  </div>
</div>

@if (count($customer_address) == 0)
  <div class="card-view-basket">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <!-- START: FORM -->
          <form class="form-gropu">
            <div class="row">
              <div class="col-6">
                <!-- START: ADDRESS 1 -->
                <div class="mb-3">
                  <label for="address_1" class="form-label">
                    Address 1</label>
                  <input type="text" class="form-control" 
                    id="address_1" 
                    placeholder="123 main street"
                    aria-describedby="address_1"
                  >
                  <div id="address_1" class="form-text">
                    Please add your address
                  </div>
                </div>
                <!-- END: ADDRESS 1 -->
  
                <!-- START: Name -->
                <div class="mb-3">
                  <label for="name" class="form-label">
                    Name</label>
                  <input type="text" class="form-control" 
                    id="name" 
                    placeholder="John doe"
                    aria-describedby="name"
                  >
                  <div id="name" class="form-text">
                    Please add your name
                  </div>
                </div>
                <!-- END: Name -->
              </div>
              <div class="col-6">
                <!-- START: ADDRESS 2 -->
                <div class="mb-3">
                  <label for="address_2" class="form-label">
                    Address 2</label>
                  <input type="text" class="form-control" 
                    id="address_2" 
                    placeholder="Apartment Khun Pa"
                    aria-describedby="address_2"
                  >
                  <div id="address_2" class="form-text">
                    Please add your address
                  </div>
                </div>
                <!-- END: ADDRESS 2 -->

                <!-- START: tel -->
                <div class="mb-3">
                  <label for="tel" class="form-label">
                    Tel</label>
                  <input type="text" class="form-control" 
                    id="tel" 
                    placeholder="0000000000"
                    aria-describedby="tel"
                  >
                  <div id="tel" class="form-text">
                    Please add your tel
                  </div>
                </div>
                <!-- END: tel -->
              </div>
            </div>
          </form>
          <!-- END: FORM -->
        </div>
      </div>
    </div>
  </div> 
@else
  <div class="card-view-basket">
    <div class="card">
      <div class="card-body">
        <p class="card-text">
          123 main street
        </p>
      </div>
    </div>
  </div> 
@endif


@endsection

@section('script')
  <script type="text/javascript" src="{{ url('js/checkout.js') }}"></script>
@endsection