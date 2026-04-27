<!DOCTYPE html>
<html lang="mk">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title', 'Еволуција на Сонот')</title>
	<meta name="description"
		content="@yield('description', 'Еволуција на Сонот - уметнички и културен фестивал во Македонија.')">
	@vite(['resources/css/main.css' , 'resources/js/app.js'])
	@stack('head')
	{{-- @stack('styles') --}}
</head>

<body class="bg-cream font-sans text-ev-dark overflow-x-hidden">

	@include('partials.navbar')

	{{-- Unified Flash Messages --}}
	@include('partials.flash')

	<main>
		@yield('content')
	</main>

	@include('partials.footer')

	@stack('scripts')
</body>

</html>