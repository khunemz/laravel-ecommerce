@extends('layouts.default')


@section('content')
<div class="card-product-view-detail loading-skeleton">
  @foreach ($products as $product)
      <div class="card" id="card-product-view-item" data-id={{$product->id}}>
        <div class="card-body">
          <div class="row">
            <div class="col-6" id="img-container">
              <img class="product-view-img img-fluid" height="100%" width="100%" src="{{$product->img_path}}" alt="{{$product->title}}" />
            </div>
            <div class="col-6">
              <header>
                <h2>{{$product->title}}</h2>
              </header>
              <article>
                <section class="product-detail-description">
                  <p class="card-text">{{ $product->description }}</p>
                </section>
                <section class="product-detail-price">
                  <h4>{{ $product->price }} บาท / {{ $product->name }}</h4>
                </section>
                <section class="adjust-quantity">
                  <button class="btn btn-outline-info d-inline-block" id="decrease-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  </button>
                  <input id="quantity" type="number" class="form-control d-inline-block" placeholder="0.00" min="1" max="999999999" />
                  <button class="btn btn-outline-info" id="increase-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  </button>
                </section>
                <section class="add-cart-buttons d-inline-block">
                  <button class="btn btn-outline-primary" id="add-to-cart-button">
                    Add to cart
                  </button>
                </section>
              </article>
            </div>
          </div>
        </div>
      </div>      
  @endforeach
</div>
@endsection

@section('script')
  <script type="text/javascript" src="{{ url('js/view.js') }}"></script>
@endsection