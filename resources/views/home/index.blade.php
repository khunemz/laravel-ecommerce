@extends('layouts.default')


@section('content')

<section class="main-content" style="padding-top: 10px;">

  <!-- START: Carousel -->
  <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('img/c_1_1.png') }}" class="d-block w-100 carousel-item-img" alt="...">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('img/c_1_2.png') }}" class="d-block w-100 carousel-item-img" alt="...">
       
      </div>
      <div class="carousel-item">
        <img src="{{ asset('img/c_1_3.png') }}" class="d-block w-100 carousel-item-img" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- END: Carousel -->

  <!-- START: Category Card -->
  <div class="card category-card">
    <div class="card-body">
      <div class="row">
        <div id="category_card_target" class="category-group"></div>
      </div>      
    </div>
  </div>
  <!-- END: Category Card -->

  <!-- START: Product List -->
  <div id="product_card_target" class="row"></div>
  <!-- END: Product List -->
</section>
@endsection

@section('hbs_template')  
<script id="product_card_template" type="text/x-handlebars-template">
  @{{#each products}}
    <div class="col-3">
      <div class="card card-product-detail loading-skeleton">
        <img class="card-img-top" src="@{{this.img_path}}" alt="Card image cap">
        <div class="card-body">
          <p class="card-text product-title-home">
            @{{this.title}} 
          </p>
          <p class="card-text">
            @{{this.price}} บาท
          </p>
        </div>
      </div>
    </div>
  @{{/each}}
</script>

<script id="category_card_template" type="text/x-handlebars-template">
  @{{#each categories}}
    <div class="category-item loading-skeleton">
      <div class="d-block">
        <img 
        src="@{{this.img}}" 
        class="d-block img-fluid"
        width="100" height="100"
        />
      </div>
      <div class="category-desc text-center">
        <a href="#" class="text-decoration-none">@{{this.name}}</a>
      </div>
    </div>
  @{{/each}}
</script>
@endsection