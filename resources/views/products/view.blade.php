@extends('layouts.default')


@section('content')
<div class="card-product-view-detail loading-skeleton">
  @foreach ($products as $product)
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-6">
              <img class="product-view-img img-fluid" src="{{$product->img_path}}" alt="{{$product->title}}" />
            </div>
            <div class="col-6">
              <header>
                <h2>{{$product->title}}</h2>
              </header>
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