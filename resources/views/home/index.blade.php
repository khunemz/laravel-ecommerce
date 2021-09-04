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
        <div class="category-group">
          <div class="category-item">
            <div class="d-block">
              <img 
              src="https://salt.tikicdn.com/cache/w100/ts/upload/31/d1/ad/8f8589ccf8a4ce2761ad51bae11eb4a6.jpg" 
              class="d-block img-fluid"
              width="100" height="100"
              />
            </div>
            <div class="category-desc text-center">
              <a href="#" class="text-decoration-none">Category # 1</a>
            </div>
          </div>
          <div class="category-item">
            <div class="d-block">
              <img 
              src="https://salt.tikicdn.com/cache/w100/ts/upload/73/e0/7d/af993bdbf150763f3352ffa79e6a7117.png" 
              class="d-block img-fluid"
              width="100" height="100"
              />
            </div>
            <div class="category-desc text-center">
              <a href="#" class="text-decoration-none">Category # 2</a>
            </div>
          </div>
          <div class="category-item">
            <div class="d-block">
              <img 
              src="https://salt.tikicdn.com/cache/w100/ts/upload/4a/b2/c5/b388ee0e511889c83fab1217608fe82f.png" 
              class="d-block img-fluid"
              width="100" height="100"
              />
            </div>
            <div class="category-desc text-center">
              <a href="#" class="text-decoration-none">Category # 3</a>
            </div>
          </div>
          <div class="category-item">
            <div class="d-block">
              <img 
              src="https://salt.tikicdn.com/cache/w100/ts/upload/a0/0d/90/bab67b6da67117f40538fc54fb2dcb5e.png" 
              class="d-block img-fluid"
              width="100" height="100"
              />
            </div>
            <div class="category-desc text-center">
              <a href="#" class="text-decoration-none">Category # 4</a>
            </div>
          </div>
          <div class="category-item">
            <div class="d-block">
              <img 
              src="https://salt.tikicdn.com/cache/w100/ts/upload/a9/58/39/872e4acbdb3576be53b57c05a386860b.png" 
              class="d-block img-fluid"
              width="100" height="100"
              />
            </div>
            <div class="category-desc text-center">
              <a href="#" class="text-decoration-none">Category # 1</a>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  <!-- START: Category Card -->

  <!-- START: Product List -->

</section>
@endsection