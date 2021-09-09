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

                <!-- START: province -->                
                <div id="province_target"></div>           
                <!-- END: province -->


                <!-- START: subdistrict -->                
                <div id="subdistrict_target"></div>    
                <!-- END: subdistrict -->

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

                <!-- START: email -->
                <div class="mb-3">
                  <label for="email" class="form-label">
                    Email</label>
                  <input type="email" class="form-control" 
                    id="email" 
                    placeholder="email@example.com"
                    aria-describedby="email"
                  >
                  <div id="email" class="form-text">
                    Please add your email
                  </div>
                </div>
                <!-- END: email -->

                <!-- START: type -->
                <div class="mb-3">
                  <label for="type" class="form-label">
                    Address type
                  </label>
                  <select class="form-select" 
                    aria-label="type" 
                    aria-describedby="type">
                    <option selected disabled>Choose your address type</option>
                    <option value="1">Home</option>
                    <option value="2">Work</option>
                  </select>
                  <div id="type" class="form-text">
                    Please add your address type
                  </div>
                </div>
                <!-- END: type -->

                <!-- START: district -->                
                <div id="district_target"></div>        
                <!-- END: district -->
               
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

<script id="province_template" type="text/x-handlebars-template">
  <div class="mb-3">
    <label for="province" class="form-label">
      Province
    </label>
    <select class="form-select" 
      aria-label="province" 
      aria-describedby="province"
      id="province_combobox"
      >
      <option selected disabled>Choose your province</option>
      @{{#each provinces}}
        <option value="@{{this.province_id}}">@{{this.province_name}}</option>
      @{{/each}}
    </select>
    <div id="province" class="form-text">
      Choose your province
    </div>
  </div>
</script>


<script id="district_template" type="text/x-handlebars-template">
  <div class="mb-3">
    <label for="district" class="form-label">
      district
    </label>
    <select class="form-select" 
      aria-label="district" 
      aria-describedby="district"
      id="district_combobox"
    
      >
      <option selected disabled>Choose your district</option>
      @{{#each districts}}
        <option value="@{{this.district_id}}">@{{this.district_name}}</option>
      @{{/each}}
    </select>
    <div id="district" class="form-text">
      Choose your district
    </div>
  </div>
</script>



<script id="subdistrict_template" type="text/x-handlebars-template">
  <div class="mb-3">
    <label for="subdistrict" class="form-label">
      Sub District
    </label>
    <select class="form-select" 
      aria-label="subdistrict" 
      aria-describedby="subdistrict"
      id="subdistrict_combobox"
      >
      <option selected disabled>Choose your subdistrict</option>
      @{{#each subdistricts}}
        <option value="@{{this.subdistrict_id}}">@{{this.subdistrict_name}}</option>
      @{{/each}}
    </select>
    <div id="subdistrict" class="form-text">
      Choose your Sub District
    </div>
  </div>
</script>


<script type="text/javascript" src="{{ url('js/checkout.js') }}"></script>
@endsection