<nav class="navbar bg-body-tertiary position-relative">
  <div class="container-lg">
    <button class="navbar-toggler" data-cy="btn-navbar-toggler" type="button" data-bs-toggle="offcanvas"
      data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="d-none d-md-block logo-img-wrapper {{Request::is('/') ? 'opacity-0': ''}}">
      <a href={{route('welcome')}}>
        <img src="{{asset('img/logo-sirepo.png')}}">
      </a>
    </div>

    @if (auth()->user() || Auth::guard('admin')->user() || Auth::guard('lecturer')->user())
    <div class="dropdown" data-cy="btn-dropdown-account">
      <a class="nav-link d-flex gap-2 pt-3 pt-md-0 align-items-center justify-content-end dropdown-toggle"
        href="user-edit-profile.html" role="button" aria-current="page" data-bs-toggle="dropdown" aria-expanded="false">
        @auth('student')
        <img src="{{asset(auth()->user()->profile_picture ? 'storage/profile/'.auth()->user()->profile_picture
        :'img/default-profile.png')}}" class="img-fluid img-avatar" />
        @endauth
        @auth('admin')
        <img src="{{asset(Auth::guard('admin')->user()->profile_picture ? 'storage/profile/'.Auth::guard('admin')->user()->profile_picture
        :'img/default-profile.png')}}" class="img-fluid img-avatar" />
        @endauth
        @auth('lecturer')
        <img src="{{asset(Auth::guard('lecturer')->user()->profile_picture ? 'storage/profile/'.Auth::guard('lecturer')->user()->profile_picture
        :'img/default-profile.png')}}" class="img-fluid img-avatar" />
        @endauth
      </a>
      @php
      $user = auth()->user()
      @endphp
      <ul class="dropdown-menu dropdown-menu-end px-2">
        <li class="rounded-2 dropdown-list">
          <p class="mb-0 text-white text-center">
            @auth('student')
            @php
            $user = auth()->user()
            @endphp
            @endauth
            @auth('admin')
            @php
            $user = Auth::guard('admin')->user()
            @endphp
            @endauth
            @auth('lecturer')
            @php
            $user = Auth::guard('lecturer')->user()
            @endphp
            @endauth
            {{$user->username}}
          </p>
        </li>
        <li class="rounded-2 dropdown-list my-profile">
          <a class="dropdown-item text-white rounded-2" href="{{route('user.editProfile', $user->id)}}"
            data-cy="btn-edit-account"><i class="ri-user-3-line me-2 text-white"></i>Edit Profil</a>
        </li>
        <li class="rounded-2 dropdown-list">
          <form action="{{route('signIn.user.signOut')}}" method="POST">
            @csrf
            <button data-cy="btn-logout" type="submit" class="dropdown-item btn-submit rounded-2 text-white"><i
                class="ri-logout-circle-line me-2 text-white"></i>Log Out</button>
          </form>
        </li>
      </ul>
    </div>
    @else
    <a href="{{route('signIn.student')}}" class="login-link text-decoration-none d-flex align-items-center gap-1 "><i
        class="ri-login-circle-line"></i>Log In</a>
    @endif
  </div>
</nav>