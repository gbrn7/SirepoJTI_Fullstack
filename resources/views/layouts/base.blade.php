<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sirepo-JTI | @yield('title')</title>
  <!-- Icon -->
  <link rel="icon" type="image/x-icon" href="{{asset('img/jti_logo.png')}}" />

  <!-- CSS Bootsrap-->
  <link rel="stylesheet" href="{{asset('vendor/bootstrap-5.2/css/bootstrap.min.css')}}" />

  <!-- Link Remixicon -->
  <link rel="stylesheet" href="{{asset('vendor/RemixIcon-master/fonts/remixicon.css')}}" />

  <!-- CSS -->
  <link rel="stylesheet" href="@yield('custom_css_link')" />
  <link rel="stylesheet" href="{{asset('css/Navbar_style/main.css')}}" />
  <link rel="stylesheet" href="{{asset('css/Off-canvase_style/main.css')}}" />
  <link rel="stylesheet" href="{{asset('css/Footer_style/main.css')}}" />
  <link rel="stylesheet" href="{{asset('css/Preloader/main.css')}}" />

</head>

<body class="d-flex flex-column justify-content-between">
  {{-- Sweet Alert --}}
  @include('sweetalert::alert')

  {{-- Preloader --}}
  @include('preloader.index')

  <div class="content-up">

    <!-- Navbar -->
    @include('layouts.navbar')

    <!-- Content -->
    <div class="container-lg content-wrapper">
      @yield('breadcrumbs')

      @yield('main-content')
    </div>

  </div>

  <!-- Off Canvas -->
  @include('layouts.offcanvas')

  <!-- Footer -->
  <div class="container-lg content-down footer-wrapper pt-3 pb-2 mt-3">
    @include('layouts.footer')
  </div>

</body>
{{-- jquery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
  integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<!-- jquery Table -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Bootstrap js -->
<script src="{{asset('vendor/bootstrap-5.2/js/bootstrap.bundle.min.js')}}"></script>

{{-- Global --}}
<script>
  let debounce = function (func, wait, immediate) {
     let timeout;
     return function() {
         let context = this, args = arguments;
         let later = function() {
                 timeout = null;
                 if (!immediate) func.apply(context, args);
         };
         let callNow = immediate && !timeout;
         clearTimeout(timeout);
         timeout = setTimeout(later, wait);
         if (callNow) func.apply(context, args);
     };
};

$(document).ready(function () {
  $('.loading-wrapper').addClass('d-none');
  });
</script>


@stack('js')

<script src="{{asset('js/preloader.js')}}"></script>

</html>