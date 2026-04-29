@extends('layouts.admin')

@section('title', 'Апликација #' . $application->id)
@section('page-title', 'Апликација - ' . $application->name . ' ' . $application->surname)

@section('content')

<div class="row g-4">
    {{-- APPLICATION DETAILS --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center py-3">
                <span><i class="fa-solid fa-circle-info me-2 text-primary"></i>Детали за апликацијата</span>
                
                <span class="badge bg-{{ $application->status === 'approved' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'warning text-dark') }}">
                    @if($application->status === 'pending')
                        <i class="fa-solid fa-hourglass-start me-1"></i> Чека одлука
                    @elseif($application->status === 'approved')
                        <i class="fa-solid fa-circle-check me-1"></i> Одобрена
                    @else
                        <i class="fa-solid fa-circle-xmark me-1"></i> Одбиена
                    @endif
                </span>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted small"><i class="fa-solid fa-user me-2"></i>Име</dt>
                    <dd class="col-sm-8">{{ $application->name }}</dd>

                    <dt class="col-sm-4 text-muted small"><i class="fa-solid fa-user me-2"></i>Презиме</dt>
                    <dd class="col-sm-8">{{ $application->surname }}</dd>

                    <dt class="col-sm-4 text-muted small"><i class="fa-solid fa-envelope me-2"></i>Е-пошта</dt>
                    <dd class="col-sm-8"><a href="mailto:{{ $application->email }}">{{ $application->email }}</a></dd>

                    <dt class="col-sm-4 text-muted small"><i class="fa-solid fa-phone me-2"></i>Телефон</dt>
                    <dd class="col-sm-8">{{ $application->phone ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted small"><i class="fa-solid fa-share-nodes me-2"></i>Социјална мрежа</dt>
                    <dd class="col-sm-8">
                        @if($application->social_media)
                            <a href="{{ $application->social_media }}" target="_blank" rel="noopener">
                                {{ $application->social_media }}
                            </a>
                        @else
                            -
                        @endif
                    </dd>

                    <dt class="col-sm-4 text-muted small"><i class="fa-solid fa-palette me-2"></i>Област</dt>
                    <dd class="col-sm-8">{{ $application->collaboration_area }}</dd>

                    <dt class="col-sm-4 text-muted small"><i class="fa-solid fa-comment-dots me-2"></i>Порака</dt>
                    <dd class="col-sm-8" style="white-space:pre-wrap;">{{ $application->message }}</dd>

                    <dt class="col-sm-4 text-muted small"><i class="fa-solid fa-calendar me-2"></i>Година</dt>
                    <dd class="col-sm-8">{{ $application->year }}</dd>

                    <dt class="col-sm-4 text-muted small"><i class="fa-solid fa-clock me-2"></i>Пријавен</dt>
                    <dd class="col-sm-8">{{ $application->created_at->format('d.m.Y H:i') }}</dd>

										{{-- Portfolio Section: Handles both File and Link --}}
										@if($application->portfolio_path)
												<dt class="col-sm-4 text-muted small">
														<i class="fa-solid fa-file-pdf me-2 text-danger"></i>Портфолио (PDF)
												</dt>
												<dd class="col-sm-8 mb-3">
														<a href="{{ asset('storage/' . $application->portfolio_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
																<i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Отвори PDF
														</a>
												</dd>
										@endif

										@if($application->portfolio_url)
												<dt class="col-sm-4 text-muted small">
														<i class="fa-solid fa-link me-2 text-info"></i>Портфолио (Линк)
												</dt>
												<dd class="col-sm-8">
														<a href="{{ $application->portfolio_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-info">
																<i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Отвори линк
														</a>
												</dd>
										@endif

                    @if($application->admin_response)
                        <div class="col-12"><hr class="my-3 text-muted opacity-25"></div>
                        <dt class="col-sm-4 text-muted small"><i class="fa-solid fa-reply me-2"></i>Одговор на админ</dt>
                        <dd class="col-sm-8" style="white-space:pre-wrap;">{{ $application->admin_response }}</dd>

                        <dt class="col-sm-4 text-muted small"><i class="fa-solid fa-calendar-check me-2"></i>Одговорено на</dt>
                        <dd class="col-sm-8">{{ $application->responded_at?->format('d.m.Y H:i') }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    {{-- DECISION FORM --}}
    <div class="col-lg-5">
        @if($application->isPending() && $application->isCurrentYear())
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold py-3">
                    <i class="fa-solid fa-gavel me-2 text-primary"></i>Донеси одлука
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.applications.review', $application) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="decision" class="form-label fw-semibold text-muted small">Одлука</label>
                            <select id="decision" name="decision" class="form-select" required>
                                <option value="" disabled selected>- изберете -</option>
                                <option value="approved" class="text-success">✅ Одобри</option>
                                <option value="rejected" class="text-danger">❌ Одбиј</option>
                            </select>
                            @error('decision')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="admin_response" class="form-label fw-semibold text-muted small">
                                Порака до уметникот
                            </label>
                            <textarea id="admin_response" name="admin_response" class="form-control" rows="3" placeholder="Внесете порака која ќе биде испратена до уметникот..." required minlength="10">{{ old('admin_response') }}</textarea>
                            @error('admin_response')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fa-solid fa-paper-plane me-2"></i>Испрати одлука
                        </button>
                    </form>
                </div>
            </div>
        @elseif(!$application->isCurrentYear())
            <div class="alert alert-warning border-0 shadow-sm">
                <i class="fa-solid fa-lock me-2"></i>
                <strong>Само за читање</strong><br>
                <span class="small">Апликациите од претходни години се заклучени за измени.</span>
            </div>
        @else
            <div class="alert alert-info border-0 shadow-sm">
                <i class="fa-solid fa-circle-check me-2"></i>
                Оваа апликација веќе е прегледана и обработена.
            </div>
        @endif

        <a href="{{ route('admin.applications.pending') }}" class="btn btn-light border w-100 mt-3">
            <i class="fa-solid fa-arrow-left me-2"></i>Назад кон листата
        </a>
    </div>
</div>

@endsection