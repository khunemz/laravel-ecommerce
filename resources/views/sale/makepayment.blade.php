@extends('layouts.default')


@section('content')

<div class="card-view-basket loading-skeleton">
 
  <div class="text-center mt-10">
    <button class="btn btn-success" id="make-order-button">ดำเนินการชำระเงิน</button>
  </div>

@endsection

@section('script')
  <script type="text/javascript" src="{{ url('js/makepayment.js') }}"></script>
@endsection