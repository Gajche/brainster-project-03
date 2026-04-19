<div class="sidebar-brand d-none d-lg-block">
    <h5>Еволуција на Сонот</h5>
    <small class="text-white">Администрација</small>
</div>

<ul class="nav flex-column py-3">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">📊 Контролна табла</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.applications.pending') ? 'active' : '' }}" href="{{ route('admin.applications.pending') }}">⏳ Чекаат одлука</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.applications.all') ? 'active' : '' }}" href="{{ route('admin.applications.all') }}">📋 Сите апликации</a>
    </li>
    <li class="nav-item border-top border-secondary mt-2 pt-2">
        <a class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}" href="{{ route('admin.profile.edit') }}">👤 Мој профил</a>
    </li>
</ul>

<div class="px-3 mt-auto mb-4"> 
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        
        <button type="submit" class="btn btn-sm btn-danger w-100 py-2 d-lg-none">
            Одјави се
        </button>
        
        <button type="submit" class="btn btn-sm btn-outline-light w-100 d-none d-lg-block">
            Одјави се
        </button>
    </form>
</div>