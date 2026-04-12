{{-- resources/views/layouts/admin.blade.php --}}
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
	<div class="d-flex">

		<nav class="admin-sidebar">
			<div class="sidebar-brand">
				<h5>Еволуција<br>на Сонот</h5>
				<small class="text-muted" style="font-size:0.7rem;">Администрација</small>
			</div>
			<ul class="nav flex-column">
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
						href="{{ route('admin.dashboard') }}">📊 Контролна табла</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('admin.applications.pending') ? 'active' : '' }}"
						href="{{ route('admin.applications.pending') }}">⏳ Чекаат одлука(pending)</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('admin.applications.all') ? 'active' : '' }}"
						href="{{ route('admin.applications.all') }}">📋 Сите апликации</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}"
						href="{{ route('admin.profile.edit') }}">👤 Мој профил</a>
				</li>
			</ul>
			<div class="px-3 mt-auto pt-4">
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<button type="submit" class="btn btn-sm btn-outline-light w-100">Одјави се</button>
				</form>
			</div>
		</nav>

		<div class="admin-main flex-grow-1">
			<div class="admin-topbar">
				<h6 class="mb-0 fw-bold">@yield('page-title', 'Контролна табла')</h6>
				<span class="text-muted small">{{ Auth::user()->name }}</span>
			</div>
			<div class="admin-content">
				@if(session('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{ session('success') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>
				@endif
				@if($errors->any())
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<ul class="mb-0">
						@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
					</ul>
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>
				@endif
				@yield('content')
			</div>
		</div>
	</div>
	@stack('scripts')
</body>

</html>