<!DOCTYPE html>
<html lang="mk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Еволуција на Сонот</title>
    @vite(['resources/css/admin.css', 'resources/js/app.js', 'resources/js/validation.js'])
    @stack('head')
</head>
<body>

    {{-- Desktop Sidebar (Hidden on mobile/tablet) --}}
    <nav class="admin-sidebar d-none d-lg-flex">
        @include('layouts.partials.admin-nav-content')
    </nav>

    {{-- Mobile Sidebar (Offcanvas - Hidden on desktop) --}}
    <div class="offcanvas offcanvas-start admin-sidebar-mobile d-lg-none" tabindex="-1" id="adminMobileMenu">
        <div class="offcanvas-header border-bottom border-secondary">
            <h5 class="offcanvas-title text-warning fw-bold">Еволуција на Сонот</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0 d-flex flex-column">
            @include('layouts.partials.admin-nav-content')
        </div>
    </div>

    <div class="admin-main">
        {{-- Topbar with Hamburger --}}
        <div class="admin-topbar shadow-sm">
            <div class="d-flex align-items-center">
                {{-- Hamburger Button (Visible only on mobile/tablet) --}}
                <button class="btn btn-link d-lg-none me-3 p-0 text-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMobileMenu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                    </svg>
                </button>
                <h6 class="mb-0 fw-bold">@yield('page-title', 'Контролна табла')</h6>
            </div>
            
            <div class="d-flex align-items-center">
                <span class="text-muted small me-2 d-none d-sm-inline">{{ Auth::user()->name }}</span>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light rounded-circle" data-bs-toggle="dropdown">
                        <i class="bi bi-person"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}">Профил</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Одјави се</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

				<div class="admin-content">
          {{-- Unified Flash Messages (Toastr logic) --}}
          @include('partials.flash')
    
          @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>