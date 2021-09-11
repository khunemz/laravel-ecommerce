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
          <form class="form-group" method="post" action="{{ url('sale/add_address'); }}">
            @csrf()
            <div class="row">
              <div class="col-6">
                <!-- START: ADDRESS 1 -->
                <div class="row mb-3">
                  <label for="address_1" class="col-sm-3 col-form-label">
                    ที่อยู่ <span class="text-danger">*</span>
                  </label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control @error('address_1') is-invalid @enderror" 
                      id="address_1" 
                      name="address_1"
                      placeholder="123 main street"
                      aria-describedby="address_1"
                      value="{{ old('address_1') }}"
                    >
                    @error('address_1')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>                 
                </div>
                <!-- END: ADDRESS 1 -->
  
                <!-- START: Name -->
                <div class="row mb-3">
                  <label for="name" class="col-sm-3 col-form-label">
                    ชื่อผู้รับ <span class="text-danger">*</span>
                  </label>
                  <div class="col-sm-9">
                    <input 
                      type="text" 
                      name="name"
                      class="form-control @error('name') is-invalid @enderror" 
                      id="name" 
                      placeholder="John doe"
                      aria-describedby="name"
                      value="{{ old('name') }}"
                    >
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <!-- END: Name -->

                <!-- START: tel -->
                <div class="row mb-3">
                  <label for="tel" class="col-sm-3 col-form-label">
                    โทรศัพท์
                  </label>
                  <div class="col-sm-9">
                    <input 
                      type="text" 
                      name="tel"
                      class="form-control @error('tel') is-invalid @enderror" 
                      id="tel" 
                      placeholder="0000000000"
                      aria-describedby="tel"
                      value="{{ old('tel') }}"
                    >
                    @error('tel')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <!-- END: tel -->

                <!-- START: province -->                
                <div id="province_target"></div>           
                <!-- END: province -->         

                <!-- START: district -->                
                <div id="district_target"></div>        
                <!-- END: district -->    

                <!-- START: zipcode -->                
                <div id="zipcode_target"></div>        
                <!-- END: zipcode -->  

              </div>
              <div class="col-6">
                <!-- START: ADDRESS 2 -->
                <div class="row mb-3">
                  <label for="address_2" class="col-sm-3 col-form-label">
                    หมู่บ้าน,ตึก
                  </label>
                  <div class="col-sm-9">
                    <input 
                      type="text" 
                      name="address_2"
                      class="form-control @error('address_2') is-invalid @enderror" 
                      id="address_2" 
                      placeholder="Apartment Khun Pa"
                      aria-describedby="address_2"
                      value="{{ old('address_2') }}"
                    >
                    @error('address_2')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <!-- END: ADDRESS 2 -->

                <!-- START: email -->
                <div class="row mb-3">
                  <label for="email" class="col-sm-3 col-form-label">
                    อีเมลล์ <span class="text-danger">*</span>
                  </label>
                  <div class="col-sm-9">
                    <input 
                      type="email" 
                      name="email"
                      class="form-control @error('email') is-invalid @enderror" 
                      id="email" 
                      placeholder="email@example.com"
                      aria-describedby="email"
                      value="{{ old('email') }}"
                    >
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <!-- END: email -->

                 <!-- START: taxno -->
                 <div class="row mb-3">
                  <label for="taxno" class="col-sm-3 col-form-label">
                    Tax ID
                  </label>
                  <div class="col-sm-9">
                    <input 
                      type="text" 
                      name="taxtno"
                      class="form-control @error('taxno') is-invalid @enderror" 
                      id="taxno" 
                      placeholder="000000000000"
                      aria-describedby="taxno"
                      value="{{ old('taxno') }}"
                    >
                    @error('taxno')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <!-- END: taxno -->

                <!-- START: type -->
                <div class="row mb-3">
                  <label for="type" class="col-sm-3 col-form-label">
                    ประเภท <span class="text-danger">*</span>
                  </label>
                  <div class="col-sm-9">
                    <select 
                      name="type"
                      class="form-select @error('type') is-invalid @enderror" 
                      aria-label="type" 
                      aria-describedby="type"
                      value="{{ old('type') }}"
                      >
                        <option selected disabled>กรุณากรอกประเภทที่อยู่</option>
                        @foreach ($types as $item)
                          <option value="{{$item['value']}}">{{ $item['text']}}</option>
                        @endforeach
                    </select>
                    @error('type')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <!-- END: type -->  

                <!-- START: subdistrict -->                
                <div id="subdistrict_target"></div>    
                <!-- END: subdistrict -->
              </div>
            </div>

            <div class="payment-button row float-right">
              <div class="d-grid gap-2 col-6 mx-auto">
                <input class="btn btn-success" type="submit" value="บันทึกและไปหน้าสรุป">
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
  <div class="row mb-3">
    <label for="province" class="col-sm-3 col-form-label">
      จังหวัด <span class="text-danger">*</span>
    </label>
    <div class="col-sm-9">
      <select 
          class="form-select @error('province_id') is-invalid @enderror" 
          name="province_id"
          aria-label="province" 
          aria-describedby="province"
          id="province_combobox"        
          value="{{ old('province_id') }}"  
        >
        <option selected disabled>Choose your province</option>
        @{{#each provinces}}
          <option value="@{{this.province_id}}">@{{this.province_name}}</option>
        @{{/each}}
      </select>
      @error('province_id')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
  </div>
</script>


<script id="district_template" type="text/x-handlebars-template">
  <div class="row mb-3">
    <label for="district" class="col-sm-3 col-form-label">
      อำเภอ <span class="text-danger">*</span>
    </label>
    <div class="col-sm-9">
      <select 
        name="district_id"
        class="form-select @error('district_id') is-invalid @enderror"
        aria-label="district" 
        aria-describedby="district"
        id="district_combobox"    
        value="{{ old('district_id') }}"
        >
        <option selected disabled>Choose your district</option>
        @{{#each districts}}
          <option value="@{{this.district_id}}">@{{this.district_name}}</option>
        @{{/each}}
      </select>
      @error('district_id')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
  </div>
</script>



<script id="subdistrict_template" type="text/x-handlebars-template">
  <div class="row mb-3">
    <label for="subdistrict" class="col-sm-3 col-form-label">
      ตำบล <span class="text-danger">*</span>
    </label>
    <div class="col-sm-9">
      <select 
        class="form-select @error('subdistrict_id') is-invalid @enderror"
        name="subdistrict_id"
        aria-label="subdistrict" 
        aria-describedby="subdistrict"
        id="subdistrict_combobox"
        value="{{ old('subdistrict_id') }}"
        >
        <option selected disabled>Choose your subdistrict</option>
        @{{#each subdistricts}}
          <option value="@{{this.subdistrict_id}}">@{{this.subdistrict_name}}</option>
        @{{/each}}
      </select>
      @error('subdistrict_id')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>
  </div>
</script>


<script id="zipcode_template" type="text/x-handlebars-template">
  <div class="row mb-3">
  <label for="zipcode" class="col-sm-3 col-form-label">
    ZipCode  <span class="text-danger">*</span>
  </label>
  <div class="col-sm-9">
    <input 
      type="text" 
      name="zipcode"
      class="form-control @error('zipcode') is-invalid @enderror" 
      id="zipcode" 
      placeholder="00000"
      aria-describedby="zipcode"
      value="{{ old('zipcode') }}"
    >
    @error('zipcode')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  </div>
</script>
<script type="text/javascript" src="{{ url('js/checkout.js') }}"></script>
@endsection