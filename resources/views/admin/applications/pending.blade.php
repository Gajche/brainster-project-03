@extends('layouts.admin')

@section('title', 'Чекаат одлука')
@section('page-title', 'Апликации - Чекаат одлука')

@section('content')

{{-- SEARCH SECTION --}}
<form method="GET" action="{{ route('admin.applications.pending') }}" class="mb-4">
    <div class="input-group w-100" style="max-width:420px;">
        <input type="text" name="search" class="form-control" placeholder="Пребарај..." value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        @if($search)
            <a href="{{ route('admin.applications.pending') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-xmark me-1"></i> Откажи
            </a>
        @endif
    </div>
</form>

{{-- DESKTOP TABLE --}}
<div class="card border-0 shadow-sm d-none d-lg-block">
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
                        <th class="text-end">Акција</th>
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
                        <td class="text-end">
                            <a href="{{ route('admin.applications.show', $app) }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-eye me-1"></i> Прегледај
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            {{-- <i class="fa-solid fa-inbox d-block mb-2 fs-3"></i> --}}
                            Нема апликации кои чекаат одлука.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MOBILE CARDS --}}
<div class="d-lg-none">
    @forelse($applications as $app)
    <div class="card border-top-0 border-end-0 border-bottom-0 border-start border-warning border-4 shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0 fw-bold text-dark">{{ $app->name }} {{ $app->surname }}</h6>
                <span class="badge bg-warning text-dark">
                    <i class="fa-solid fa-clock me-1"></i> Чека
                </span>
            </div>
            
            <div class="small mb-3">
                <div class="mb-1">
                    <i class="fa-solid fa-envelope text-muted me-2"></i> {{ $app->email }}
                </div>
                <div class="mb-1">
                    <i class="fa-solid fa-phone text-muted me-2"></i> {{ $app->phone ?? 'Нема број' }}
                </div>
                <div>
                    <i class="fa-solid fa-calendar-days text-muted me-2"></i> {{ $app->created_at->format('d.m.Y') }}
                </div>
            </div>

            <a href="{{ route('admin.applications.show', $app) }}" class="btn btn-primary w-100">
                <i class="fa-solid fa-file-pen me-1"></i> Прегледај и одлучи
            </a>
        </div>
    </div>
    @empty
    <div class="text-center py-5 bg-white rounded shadow-sm">
        {{-- <i class="fa-solid fa-folder-open text-muted mb-2 fs-2 d-block"></i> --}}
        <p class="text-muted mb-0">Нема апликации кои чекаат одлука.</p>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="mt-3">
    {{ $applications->links() }}
</div>

@endsection