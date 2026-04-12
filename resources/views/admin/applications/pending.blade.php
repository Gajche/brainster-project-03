@extends('layouts.admin')

@section('title', 'Чекаат одлука')
@section('page-title', 'Апликации - Чекаат одлука')

@section('content')

{{-- Search form --}}
<form method="GET" action="{{ route('admin.applications.pending') }}" class="mb-4">
	<div class="input-group" style="max-width:420px;">
		<input type="text" name="search" class="form-control"
			placeholder="Пребарај по име, презиме, e-пошта, телефон..."
			value="{{ $search ?? '' }}">
		<button type="submit" class="btn btn-primary">Пребарај</button>
		@if($search)
		<a href="{{ route('admin.applications.pending') }}" class="btn btn-outline-secondary">
			Откажи
		</a>
		@endif
	</div>
</form>

<div class="card border-0 shadow-sm">
	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table table-hover mb-0">
				<thead class="table-light">
					<tr>
						<th>#</th>
						<th>Уметник</th>
						<th>Е-пошта</th>
						<th>Телефон</th>
						<th>Год.</th>
						<th>Пријавен</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@forelse($applications as $app)
					<tr>
						<td class="text-muted small">{{ $app->id }}</td>
						<td class="fw-semibold">{{ $app->name }} {{ $app->surname }}</td>
						<td class="small">{{ $app->email }}</td>
						<td class="small">{{ $app->phone ?? '-' }}</td>
						<td class="small">{{ $app->year }}</td>
						<td class="small text-muted">{{ $app->created_at->format('d.m.Y') }}</td>
						<td>
							<a href="{{ route('admin.applications.show', $app) }}"
								class="btn btn-sm btn-primary">Прегледај</a>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="7" class="text-center text-muted py-4">
							Нема апликации кои чекаат одлука.
						</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>

{{-- Pagination --}}
<div class="mt-3">
	{{ $applications->links() }}
</div>

@endsection