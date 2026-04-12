@extends('layouts.admin')

@section('title', 'Апликација #' . $application->id)
@section('page-title', 'Апликација - ' . $application->name . ' ' . $application->surname)

@section('content')

<div class="row g-4">
	{{-- Application details --}}
	<div class="col-lg-7">
		<div class="card border-0 shadow-sm mb-4">
			<div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
				Детали за апликацијата
				<span class="badge badge-{{ $application->status }}">
					@if($application->status === 'pending') Чека одлука
					@elseif($application->status === 'approved') Одобрена
					@else Одбиена
					@endif
				</span>
			</div>
			<div class="card-body">
				<dl class="row mb-0">
					<dt class="col-sm-4 text-muted small">Име</dt>
					<dd class="col-sm-8">{{ $application->name }}</dd>
					<dt class="col-sm-4 text-muted small">Презиме</dt>
					<dd class="col-sm-8">{{ $application->surname }}</dd>
					<dt class="col-sm-4 text-muted small">Е-пошта</dt>
					<dd class="col-sm-8"><a href="mailto:{{ $application->email }}">{{ $application->email }}</a></dd>
					<dt class="col-sm-4 text-muted small">Телефон</dt>
					<dd class="col-sm-8">{{ $application->phone ?? '-' }}</dd>
					<dt class="col-sm-4 text-muted small">Социјална мрежа</dt>
					<dd class="col-sm-8">
						@if($application->social_media)
						<a href="{{ $application->social_media }}" target="_blank" rel="noopener">
							{{ $application->social_media }}
						</a>
						@else
						-
						@endif
					</dd>
					<dt class="col-sm-4 text-muted small">Област</dt>
					<dd class="col-sm-8">{{ $application->collaboration_area }}</dd>
					<dt class="col-sm-4 text-muted small">Порака</dt>
					<dd class="col-sm-8" style="white-space:pre-wrap;">{{ $application->message }}</dd>
					<dt class="col-sm-4 text-muted small">Година</dt>
					<dd class="col-sm-8">{{ $application->year }}</dd>
					<dt class="col-sm-4 text-muted small">Пријавен</dt>
					<dd class="col-sm-8">{{ $application->created_at->format('d.m.Y H:i') }}</dd>
					@if($application->portfolio_path)
					<dt class="col-sm-4 text-muted small">Портфолио</dt>
					<dd class="col-sm-8">
						<a href="{{ asset('storage/' . $application->portfolio_path) }}"
							target="_blank" class="btn btn-sm btn-outline-primary">
							Отвори PDF
						</a>
					</dd>
					@endif
					@if($application->admin_response)
					<dt class="col-sm-4 text-muted small">Одговор на администраторот</dt>
					<dd class="col-sm-8" style="white-space:pre-wrap;">{{ $application->admin_response }}</dd>
					<dt class="col-sm-4 text-muted small">Одговорено на</dt>
					<dd class="col-sm-8">{{ $application->responded_at?->format('d.m.Y H:i') }}</dd>
					@endif
				</dl>
			</div>
		</div>
	</div>

	{{-- Review form - only for pending current-year applications --}}
	<div class="col-lg-5">
		@if($application->isPending() && $application->isCurrentYear())
		<div class="card border-0 shadow-sm">
			<div class="card-header bg-white fw-bold">Донеси одлука</div>
			<div class="card-body">
				<form method="POST"
					action="{{ route('admin.applications.review', $application) }}">
					@csrf

					<div class="mb-3">
						<label class="form-label fw-semibold">Одлука</label>
						<select name="decision" class="form-select" required>
							<option value="" disabled selected>- изберете -</option>
							<option value="approved">✅ Одобри</option>
							<option value="rejected">❌ Одбиј</option>
						</select>
						@error('decision')
						<div class="text-danger small">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label for="admin_response" class="form-label fw-semibold">
							Порака до уметникот
						</label>
						<textarea id="admin_response" name="admin_response"
							class="form-control" rows="5"
							placeholder="Внесете порака која ќе биде испратена до уметникот..."
							required minlength="10">{{ old('admin_response') }}</textarea>
						@error('admin_response')
						<div class="text-danger small">{{ $message }}</div>
						@enderror
					</div>

					<button type="submit" class="btn btn-primary w-100">
						Испрати одлуката
					</button>
				</form>
			</div>
		</div>
		@elseif(!$application->isCurrentYear())
		<div class="alert alert-warning">
			<strong>Само за читање</strong><br>
			Апликациите од претходни години не можат да се преземат акции.
		</div>
		@else
		<div class="alert alert-info">
			Оваа апликација веќе е прегледана.
		</div>
		@endif

		<a href="{{ route('admin.applications.pending') }}" class="btn btn-link ps-0 mt-2">
			Назад кон листата
		</a>
	</div>
</div>

@endsection