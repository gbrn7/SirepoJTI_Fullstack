<div class="offcanvas offcanvas-start cursor-pointer" tabindex="5" id="offcanvasNavbar"
  aria-labelledby="offcanvasNavbarLabel" data-bs-scroll="true">
  <a href="{{route('welcome')}}" class="offcanvas-header text-decoration-none d-flex justify-content-between">
    <img src="{{asset('img/logo-sirepo-white.png')}}" class="sidebar-logo" />
    <i class="ri-close-line text-white-50 fs-2 close-icon" data-bs-dismiss="offcanvas" aria-label="Close"></i>
  </a>
  <div class="offcanvas-body mt-1 p-0">
    <ul class="navbar-nav justify-content-end flex-grow-1">
      <li class="nav-item py-1 fw-light ps-3">
        <a class="nav-link active d-flex align-items-center gap-2 text-white" aria-current="page"
          href="{{route('home')}}"><i class="ri-home-2-fill nav-icon fs-5"></i><span class="Nav-text">Beranda</span></a>
      </li>
      @if (Auth::guard('admin')->check())
      <li class="nav-item py-1 fw-light ps-3">
        <a class="nav-link active d-flex align-items-center gap-2 text-white" aria-current="page"
          href="{{route('user-management.index')}}"><i class="ri-team-line nav-icon fs-5"></i><span
            class="Nav-text">User
            Management</span></a>
      </li>
      <li class="nav-item py-1 fw-light ps-3">
        <a class="nav-link active d-flex align-items-center gap-2 text-white" aria-current="page"
          href="{{route('categories.index')}}"><i class="ri-file-copy-2-fill nav-icon fs-5"></i><span
            class="Nav-text">Categories Management</span></a>
      </li>
      <li class="nav-item py-1 fw-light ps-3">
        <a class="nav-link active d-flex align-items-center gap-2 text-white" aria-current="page"
          href="{{route('documents-management.index')}}"><i class="ri-article-fill nav-icon fs-5"></i><span
            class="Nav-text">Tugas Akhir</span></a>
      </li>
      @elseif (Auth::guard('student')->check())
      <li class="nav-item py-1 fw-light ps-3">
        <a class="nav-link active d-flex align-items-center gap-2 text-white" aria-current="page"
          href="{{route('thesis-submission.index')}}"><i class="ri-article-fill nav-icon fs-5"></i><span
            class="Nav-text">Tugas Akhir</span></a>
      </li>
      @endif
    </ul>
  </div>
</div>