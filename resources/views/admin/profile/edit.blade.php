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
					<label class="form-label">Корисничко име</label>
					<input type="text" name="name" class="form-control"
						value="{{ old('name', $user->name) }}" required>
				</div>
				<div class="col-sm-6">
					<label class="form-label">Име</label>
					<input type="text" name="first_name" class="form-control"
						value="{{ old('first_name', $profile->first_name) }}">
				</div>
				<div class="col-sm-6">
					<label class="form-label">Презиме</label>
					<input type="text" name="last_name" class="form-control"
						value="{{ old('last_name', $profile->last_name) }}">
				</div>
				<div class="col-sm-6">
					<label class="form-label">Телефон</label>
					<input type="tel" name="phone" class="form-control"
						value="{{ old('phone', $profile->phone) }}">
				</div>
				<div class="col-sm-6">
					<label class="form-label">Град</label>
					<input type="text" name="city" class="form-control"
						value="{{ old('city', $profile->city) }}">
				</div>
				<div class="col-12">
					<label class="form-label">Адреса</label>
					<input type="text" name="address" class="form-control"
						value="{{ old('address', $profile->address) }}">
				</div>
				<div class="col-12">
					<label class="form-label text-muted">Е-пошта</label>
					<input type="email" class="form-control" value="{{ $user->email }}"
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