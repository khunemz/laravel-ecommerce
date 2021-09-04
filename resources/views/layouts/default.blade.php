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
  <link rel="apple-touch-icon" href="icon.png"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="{{ url('css/app.css') }}" rel="stylesheet" type="text/css"/>
  <link href="{{ url('css/styles.css'); }}" rel="stylesheet" type="text/css"/>
  <meta name="theme-color" content="#fafafa">
</head>

<body>
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
            <a class="nav-link p-2" href="/" 
            onclick="ga('send', 'event', 'Navbar', 'Community links', 'Bootstrap');">หน้าหลัก</a>
          </li>
          <li class="nav-item col-6 col-md-auto">
            <a class="nav-link p-2 active" aria-current="true" 
            href="/docs/5.0/getting-started/introduction/" 
            onclick="ga('send', 'event', 'Navbar', 'Community links', 'Docs');">สินค้าทั้งหมด</a>
          </li>
          <li class="nav-item col-6 col-md-auto">
            <a class="nav-link p-2" href="/docs/5.0/examples/" 
            onclick="ga('send', 'event', 'Navbar', 'Community links', 'Examples');">ติดตามสถานะ</a>
          </li>
         
        </ul>  
        <hr class="d-md-none text-white-50">           
        <ul class="navbar-nav flex-row flex-wrap ms-md-auto">
          

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </a>
            <div class="dropdown-menu account-dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Setting</a>
              <a class="dropdown-item" href="#">Profile</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Logout</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- END: navbar -->

  <!-- START: content -->
  <div class="container">
    @yield('content')
  </div>
  <!-- END: content -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  @yield('hbs_template')
  <script src="{{ url('js/app.js') }}"></script>
  
  @yield('script')
</body>
</html>
