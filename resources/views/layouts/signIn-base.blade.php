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
  <link rel="stylesheet" href="{{asset('Css/Login_style/main.css')}}" />

  {{-- Preload --}}
  <link rel="stylesheet" href="{{asset('Css/Preloader/main.css')}}" />

</head>

<body>
  @include('sweetalert::alert')

  {{-- Preloader --}}
  @include('preloader.index')

  <section class="login row justify-content-between">
    <div class="content-left col-lg-7 d-none d-lg-block h-100" style="
          background: url('@yield('background_url')');
          background-size: cover;
          background-position-x: @yield('bg-position-x', 'center');
          background-position-y: @yield('bg-position-y', 'center');
        "></div>
    <div class="col-lg-5 col-12 h-100 content-right">
      <div class="row justify-content-center align-items-center h-100">
        <div class="border border-2 signin-box p-3 p-sm-4 rounded rounded-5 col-8 col-md-6">
          <div class="header">
            <div class="text-center">
              <div class="logo-wrapper d-flex gap-3 justify-content-center">
                <img src="{{asset('img/jti_logo.png')}}" class="header-logo" />
                <img src="{{asset('img/polinema_logo.png')}}" class="header-logo" />
              </div>
              <h1 class="my-0 mt-4 fs-3">@yield('title')</h1>
            </div>
          </div>
          <form action="@yield('form_action')" method="post">
            @csrf
            <div class="login-form d-flex flex-column gap-1 gap-lg-3 mt-3">
              <div class="username-input-wrapper">
                <input name="username" value="{{old('email')}}" class="form-control text-black" id="username"
                  placeholder="Masukan username" />
                @error('username')
                <small class="form-text mt-1 text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="password-container">
                <div class="pass-wrapper">
                  <input name="password" type="password" class="form-control text-" id="password"
                    placeholder="Masukan password" />
                </div>
              </div>
              <button class="btn login-btn mt-1 mt-lg-2 btn-submit" type="submit">
                Sign In
              </button>
              <a href="@yield('custom_link')"
                class="text-decoration-none fw-light text-center link-text">@yield('custom_link_label')</a>
            </div>
          </form>
          <div class="auth-footer text-center text-secondary mt-1">
            <span class="copyright">Copyright ©{{date('Y')}}, Sirepo-JTI</span>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
{{-- jquery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
  integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  $(document).ready(function () {
  $('.loading-wrapper').addClass('d-none');
  });
</script>

<!-- Bootstrap js -->
<script src="{{asset('vendor/bootstrap-5.2/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('Js/preloader.js')}}"></script>

</html>