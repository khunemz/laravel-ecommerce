<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>E commerce</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="{{ url('icon.png')}}"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="{{ url('css/app.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ url('css/styles.css'); }}" rel="stylesheet" type="text/css"/>
  <meta name="theme-color" content="#fafafa">
</head>

<body>

  <div class="overlay" id="overlay"></div>
  <div class="spanner" id="spanner">
    <div class="loader" id="loader"></div>
  </div>
  <!-- START: navbar -->
  <header class="navbar navbar-expand-md navbar-dark bd-navbar bg-primary">
    <nav class="container-xxl flex-wrap flex-md-nowrap" aria-label="Main navigation">
      <a class="navbar-brand p-0 me-2" href="/" aria-label="Bootstrap">
        <img src="https://salt.tikicdn.com/ts/upload/ae/f5/15/2228f38cf84d1b8451bb49e2c4537081.png" alt="logo" style="height: 40px">
      </a>
  
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" class="bi" fill="currentColor" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"></path>
        </svg>  
      </button>
  
      <div class="collapse navbar-collapse" id="bdNavbar">
        <ul class="navbar-nav flex-row flex-wrap bd-navbar-nav pt-2 py-md-0">
          <li class="nav-item col-6 col-md-auto">
            <a class="nav-link p-2" href="{{ url('/') }}">????????????????????????</a>
          </li>
          {{-- <li class="nav-item col-6 col-md-auto">
            <a class="nav-link p-2 active" aria-current="true" 
            href="{{ url('/products') }}">???????????????????????????????????????</a>
          </li> --}}
          <li class="nav-item col-6 col-md-auto">
            <a class="nav-link p-2"  href="{{ url('/tracking') }}">?????????????????????????????????</a>
          </li>         
        </ul>  
        <hr class="d-md-none text-white-50">           
        <ul class="navbar-nav flex-row flex-wrap ms-md-auto">
          <li class="nav-item">
            <a class="nav-link p-2"  href="{{ url('sale/viewbasket') }}">
              <div id="shopping-cart">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <span class='badge badge-warning' id='basket-count'></span>
              </div>
            </a>
          </li>
          @auth       
          <li class="nav-item">
            <a class="nav-link" href="javascript:void(0)">
              Logged in as {{ auth()->user()->name }}
            </a>
          </li>
          
          <li class="nav-item">
            <form class="nav-link" action="{{ url('logout') }}" method="POST">
              @csrf()
              <button type="submit" value="">Logout</button>
            </form>
          </li>
          @endauth
          @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ url('login') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('register') }}">register</a>
          </li>
          @endguest

            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- END: navbar -->

  <!-- START: content -->
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i></a></li>
      <?php $segments = ''; ?>
      
  </ol>

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li>
        <a href="#"><i class="fa fa-dashboard"></i></a>
      </li>
      @foreach(Request::segments() as $segment)
        <?php $segments .= '/'.$segment; ?>
        <li class="breadcrumb-item">
          <a href="javascript:void(0)">{{$segment}}</a>
        </li>
      @endforeach
      
    </ol>
  </nav>
  
    @yield('content')
  </div>
  <!-- END: content -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script>
    const BASE_URL = "{{ url('/')}}";
    const CSRF_TOKEN = "{{ csrf_token() }}";

    const getBasket = function() {
      const customer_id = 1;
      $.get(`${BASE_URL}/sale/getBasket/${customer_id}`,{})
      .done(function(data, xhrStatus, jqXHR) {
        if (xhrStatus == "success") {
          let basket_count = 0;
          if(data.data.basket.length > 0) {
            basket_count = data.data.basket[0].sum_quantity;
          }
          document.getElementById('basket-count').innerHTML = basket_count;
        }
      })
      .fail(function(data, xhrStatus, jqXHR) {
        console.log(xhrStatus);
      });
    }
    getBasket();

    const finalizeLoading = function() {
      const el = document.querySelector(".loading-skeleton");
      if (el.classList.contains("loading-skeleton")) {
          el.classList.remove("loading-skeleton");
      }
    }

    jQuery.ajaxSetup({
      beforeSend: function() {
        document.getElementById('overlay').classList.add('show');
        document.getElementById('spanner').classList.add('show');
        $('#loader').show();
      },
      complete: function(){
        document.getElementById('overlay').classList.remove('show');
        document.getElementById('spanner').classList.remove('show');
        $('#loader').hide();
      },
      success: function() {}
    });
    
  </script>
  @yield('hbs_template')
  <script src="{{ url('js/app.js') }}"></script>
  @yield('script')
</body>
</html>
