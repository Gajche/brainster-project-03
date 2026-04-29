@extends('layouts.admin')

@section('title', 'Контролна табла')
@section('page-title', 'Контролна табла')

@section('content')

{{-- Stats --}}
@if(!empty($stats))
<div class="row g-3 mb-4">
	<div class="col-sm-6 col-xl-3">
		<div class="stat-card">
			<h3>{{ $stats['total'] }}</h3>
			<p>Вкупно апликации</p>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="stat-card pending">
			<h3>{{ $stats['pending'] }}</h3>
			<p>Чекаат одлука</p>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="stat-card approved">
			<h3>{{ $stats['approved'] }}</h3>
			<p>Одобрени</p>
		</div>
	</div>
	<div class="col-sm-6 col-xl-3">
		<div class="stat-card rejected">
			<h3>{{ $stats['rejected'] }}</h3>
			<p>Одбиени</p>
		</div>
	</div>
</div>
@endif

{{-- Approved applications grouped by year --}}
@forelse($approvedByYear as $year => $applications)
<div class="card mb-4 border-0 shadow-sm">
	<div class="card-header bg-white fw-bold">
		Одобрени апликации - {{ $year }}
	</div>
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table table-hover mb-0">
				<thead class="table-light">
					<tr>
						<th>#</th>
						<th>Уметник</th>
						<th>Е-пошта</th>
						<th>Област</th>
						<th>Одобрено</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($applications as $app)
					<tr>
						<td class="text-muted small">{{ $app->id }}</td>
						<td>{{ $app->name }} {{ $app->surname }}</td>
						<td class="small">{{ $app->email }}</td>
						<td class="small">{{ $app->collaboration_area }}</td>
						<td class="small text-muted">{{ $app->responded_at?->format('d.m.Y') }}</td>
						<td>
							<a href="{{ route('admin.applications.show', $app) }}"
								class="btn btn-sm btn-outline-primary">Прегледај</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@empty
<div class="alert alert-info">Нема одобрени апликации.</div>
@endforelse

{{-- Call to Action Button --}}
<div class="text-center mt-4 mb-0">
    <a href="{{ route('admin.applications.all') }}" class="btn btn-primary px-4 shadow-sm">
        <i class="fas fa-list-ul me-2"></i> Види ги сите апликации
    </a>
</div>

@endsection