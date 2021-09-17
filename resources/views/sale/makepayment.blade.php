@extends('layouts.default')


@section('content')

<div class="card-view-basket loading-skeleton">
  <div class="card">
    <div class="card-body">
      <form action="{{ url('sale/complete_payment')}}" method="post" id="checkout">
        @csrf()
        <input type="hidden" name="order_id" value="{{ $order_header->id }}" />
        <!-- Error will append here if it has -->

          @if (\Session::has('error'))          
          <div id="" class="alert alert-danger">
            {{Session::get('error')}}
          </div>
          @else
          <div id="token_errors" class="alert alert-danger">
            กรุณากรอกข้อมูล
          </div>
          @endif
     
        <!-- Keep token from tokenize step here and resend the form again (see more below in javascript section) -->
        <input type="hidden" name="omise_token">
        <div class="row mb-3">
            <div class="col-xs-12">
                <!-- Collect a card holder name -->
                <div class="row mb-3">
                  <label for="address_1" class="col-sm-3 col-form-label">
                    ชื่อเจ้าของบัตร <span class="text-danger">*</span>
                  </label>
                  <div class="col-sm-9">
                    <input name="holder_name" 
                      type="text" 
                      data-omise="holder_name" 
                      value="{{ old('holder_name')}}" 
                      class="form-control"
                      placeholder="Your name on card"
                      >
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="address_1" class="col-sm-3 col-form-label">
                    เลขที่บัตร <span class="text-danger">*</span>
                  </label>
                  <div class="col-sm-9">
                    <input name="number" 
                    type="text" 
                    data-omise="number" 
                    value="{{ old('number')}}" 
                    class="form-control"
                    placeholder="Your card number"
                    >                  
                  </div>
                </div>                
               
                <div class="row mb-3">
                  <label for="address_1" class="col-sm-3 col-form-label">
                    วันหมดอายุ <span class="text-danger">*</span>
                  </label>
                  <div class="col-sm-4">
                    <input name="expiration_month" 
                      type="text" 
                      data-omise="expiration_month" 
                      value="{{ old('expiration_month')}}" 
                      class="form-control"
                      placeholder="01"
                    >                  
                  </div>
                  <div class="col-sm-5">
                    <input name="expiration_year" 
                      type="text" 
                      data-omise="expiration_year" 
                      value="{{ old('expiration_year')}}" 
                      class="form-control"
                      placeholder="2021"
                    >                  
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="address_1" class="col-sm-3 col-form-label">
                    CVV <span class="text-danger">*</span>
                  </label>
                  <div class="col-sm-9">
                    <input name="security_code" 
                    type="text" 
                    data-omise="security_code" 
                    value="{{ old('security_code')}}" 
                    class="form-control"
                    placeholder="123"
                    >                  
                  </div>
                </div>   
                <span class="omise-circle" style=""></span>
            </div> <!-- /END .col-xs-12 -->
        </div> <!-- /END .row -->
        <!-- Submit button -->
        <div class="text-center mt-10">
          <input type="submit"  class="btn btn-success" id="create_token" value="ดำเนินการชำระเงิน">
        </div>
    </form>
    </div> <!-- card body -->
  </div><!-- // card -->

  <div class="card card-total-basket">
    <div class="card-body">
      <p class="card-text">สินค้าทั้งหมด {{ $order_header->quantity }} รายการ</p>
      <p class="card-text">
        <header><strong>คำสั่งซื้อหมายเลข</strong> {{ $order_header->docno }}</header>
      </p>
    </div>
  </div>

  @foreach ($order_item as $item)
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
            {{ number_format($order_header->grand_amount, 2) }} บาท
          </span>
        </div>
        
        <div class="basket-summary">
          <span class="">
            <strong>ส่วนลด</strong>
          </span>
          <span class="">
            {{ number_format($order_header->discount_amount, 2) }} บาท
          </span>
        </div>

        <div class="basket-summary">
          <span class="">
            <strong>ยอดรวมทั้งสิ้น</strong>
          </span>
          <span class="">
            {{ number_format($order_header->net_amount, 2) }} บาท
          </span>
        </div>
      </div>      
    </div>
  </div>
</div>
@endsection

@section('script')
  <script src="https://cdn.omise.co/omise.js"></script> 
  <script type="text/javascript" src="{{ url('js/makepayment.js') }}"></script>
  <script>
    // Set Omise Public Key (from omise.co > log in > Keys tab)
      Omise.setPublicKey("pkey_test_5p5i37wkk2py0pojoeo");
  </script>
  <script>
    $("#checkout").submit(function () {        
        $("#token_errors").html('submitting...');        
        var form = $(this);
        form.find("input[type=submit]").prop("disabled", true);
        var card = {
            "name": form.find("[data-omise=holder_name]").val(),
            "number": form.find("[data-omise=number]").val(),
            "expiration_month": form.find("[data-omise=expiration_month]").val(),
            "expiration_year": form.find("[data-omise=expiration_year]").val(),
            "security_code": form.find("[data-omise=security_code]").val()
        };

        Omise.createToken("card", card, function (statusCode, response) {
            console.log(response)
            if (response.object == "error") {
                // Display an error message.
                $("#token_errors").html(response.message);
                // Re-enable the submit button.
                form.find("input[type=submit]").prop("disabled", false);
            } else {
                // Then fill the omise_token.
                form.find("[name=omise_token]").val(response.id);
                
                $("#token_errors").addClass('success').html('กรุณาสักครู่ กรุณาอย่าออกจากหน้านี้ หรือกด refresh');
                setTimeout(function(){
                    form.get(0).submit();
                }, 3000);
                // And submit the form.
            };
        });
        // Prevent the form from being submitted;
        return false;
    });
</script>
@endsection