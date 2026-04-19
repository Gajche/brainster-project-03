@extends('layouts.admin')

@section('title', 'Сите апликации')
@section('page-title', 'Сите апликации')

@section('content')

{{-- Search Form --}}
<form method="GET" action="{{ route('admin.applications.all') }}" class="mb-4">
    <div class="input-group w-100" style="max-width: 420px;">
        <input type="text" name="search" class="form-control" placeholder="Пребарај..." value="{{ $search ?? '' }}">
        <button type="submit" class="btn btn-primary">Пребарај</button>
        @if($search)
            <a href="{{ route('admin.applications.all') }}" class="btn btn-outline-secondary">Откажи</a>
        @endif
    </div>
</form>

{{-- DESKTOP TABLE (Visible on lg and up) --}}
<div class="card border-0 shadow-sm d-none d-lg-block">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Уметник</th>
                        <th>Е-пошта</th>
                        <th>Год.</th>
                        <th>Статус</th>
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
                        <td class="small">{{ $app->year }}</td>
                        <td>
                            <span class="badge badge-{{ $app->status }}">
                                @if($app->status === 'pending') Чека
                                @elseif($app->status === 'approved') Одобрена
                                @else Одбиена @endif
                            </span>
                        </td>
                        <td class="small text-muted">{{ $app->created_at->format('d.m.Y') }}</td>
                        <td>
                            <a href="{{ route('admin.applications.show', $app) }}" class="btn btn-sm btn-outline-primary">Прегледај</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Нема апликации.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MOBILE/TABLET CARDS (Visible on everything below lg) --}}
<div class="d-lg-none">
    @forelse($applications as $app)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                    <h6 class="mb-0 fw-bold">{{ $app->name }} {{ $app->surname }}</h6>
                    <small class="text-muted">#{{ $app->id }} • {{ $app->created_at->format('d.m.Y') }}</small>
                </div>
                <span class="badge badge-{{ $app->status }}">
                    @if($app->status === 'pending') Чека
                    @elseif($app->status === 'approved') Одобрена
                    @else Одбиена @endif
                </span>
            </div>
            
            <div class="row g-2 mb-3">
                <div class="col-12">
                    <small class="text-muted d-block">Е-пошта</small>
                    <span class="small">{{ $app->email }}</span>
                </div>
                <div class="col-6">
                    <small class="text-muted d-block">Година</small>
                    <span class="small">{{ $app->year }}</span>
                </div>
            </div>

            <a href="{{ route('admin.applications.show', $app) }}" class="btn btn-primary w-100">Прегледај апликација</a>
        </div>
    </div>
    @empty
    <div class="text-center py-5 bg-white rounded shadow-sm">
        <p class="text-muted mb-0">Нема апликации.</p>
    </div>
    @endforelse
</div>

<div class="mt-3">
    {{ $applications->links() }}
</div>

@endsection