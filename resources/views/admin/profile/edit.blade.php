@extends('layouts.admin')

@section('title', 'Мој профил')
@section('page-title', 'Мој профил')

@section('content')

<div class="card border-0 shadow-sm" style="max-width:600px;">
	<div class="card-header bg-white fw-bold">Уреди профил</div>
	<div class="card-body">
		<form method="POST" action="{{ route('admin.profile.update') }}">
			@csrf
			@method('PATCH')

			<div class="row g-3">
				<div class="col-12">
					<label class="form-label" for="name">Корисничко име</label>
					<input type="text" id="name" name="name" class="form-control"
						value="{{ old('name', $user->name) }}" autocomplete="name" required>
				</div>
				<div class="col-sm-6">
					<label for="first-name" class="form-label">Име</label>
					<input id="first-name" type="text" name="first_name" class="form-control"
						value="{{ old('first_name', $profile->first_name) }}" autocomplete="first_name">
				</div>
				<div class="col-sm-6">
					<label for="last-name" class="form-label">Презиме</label>
					<input id="last-name" type="text" name="last_name" class="form-control"
						value="{{ old('last_name', $profile->last_name) }}" autocomplete="family_name">
				</div>
				<div class="col-sm-6">
					<label for="phone" class="form-label">Телефон</label>
					<input id="phone" type="tel" name="phone" class="form-control"
						value="{{ old('phone', $profile->phone) }}" autocomplete="tel">
				</div>
				<div class="col-sm-6">
					<label for="city" class="form-label">Град</label>
					<input id="city" type="text" name="city" class="form-control"
						value="{{ old('city', $profile->city) }}" autocomplete="address-level2">
				</div>
				<div class="col-12">
					<label for="address" class="form-label">Адреса</label>
					<input id="address" type="text" name="address" class="form-control"
						value="{{ old('address', $profile->address) }}" autocomplete="address">
				</div>
				<div class="col-12">
					<label for="email" class="form-label text-muted">Е-пошта</label>
					<input id="email" type="email" class="form-control" value="{{ $user->email }}" autocomplete="email"
						disabled>
					<small class="text-muted">Е-поштата не може да се менува.</small>
				</div>
				<div class="col-12">
					<button type="submit" class="btn btn-primary">Зачувај промени</button>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection