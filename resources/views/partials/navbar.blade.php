<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary fs-4" href="{{ route('landing') }}">
        <i class="bi bi-briefcase-fill me-1"></i> FreelanceAja
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @auth
            @if(session('active_role') == 'freelancer')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('freelancer.home') ? 'active fw-bold text-primary' : '' }}" href="{{ route('freelancer.home') }}">
                        {{ __('freelancer.dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('freelancer.jobs.*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('freelancer.jobs.index') }}">
                        {{ __('freelancer.browse_jobs') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('freelancer.proposals.*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('freelancer.proposals.index') }}">
                        My Proposals
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('freelancer.contracts.*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('freelancer.contracts.index') }}">
                        {{ __('freelancer.my_contracts') }}
                    </a>
                </li>
            @endif

            @if(session('active_role') == 'client')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.home') ? 'active fw-bold text-primary' : '' }}" href="{{ route('client.home') }}">
                        {{ __('client.dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.jobs.index') ? 'active fw-bold text-primary' : '' }}" href="{{ route('client.jobs.index') }}">
                        {{ __('client.my_job_postings') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('client.contracts.*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('client.contracts.index') }}">
                         Contracts
                    </a>
                </li>
            @endif
        @endauth
      </ul>

      <div class="d-flex align-items-center gap-3">
        <div class="dropdown">
            <a href="#" class="text-decoration-none text-muted small dropdown-toggle" id="langDropdown" data-bs-toggle="dropdown">
                <i class="bi bi-globe"></i> {{ strtoupper(app()->getLocale()) }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="langDropdown">
                <li><a class="dropdown-item" href="{{ route('locale.set', 'en') }}">English</a></li>
                <li><a class="dropdown-item" href="{{ route('locale.set', 'id') }}">Bahasa</a></li>
            </ul>
        </div>

        @auth
            @if(session('active_role') == 'client')
                <a href="{{ route('client.jobs.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="bi bi-plus-lg"></i> {{ __('client.post_new_job') }}
                </a>
            @endif

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 35px; height: 35px; font-weight: bold;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="d-none d-lg-block text-dark small">
                        <span class="fw-bold d-block">{{ Auth::user()->name }}</span>
                    </div>
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown">
                    <li class="px-3 py-2 border-bottom">
                        <span class="d-block small text-muted text-uppercase">Signed in as</span>
                        <span class="fw-bold text-primary">{{ ucfirst(session('active_role', 'Freelancer')) }}</span>
                    </li>

                    @if(session('active_role') == 'freelancer')
                        <li><a class="dropdown-item py-2" href="{{ route('freelancer.profile.show') }}"><i class="bi bi-person me-2"></i> {{ __('freelancer.my_profile') }}</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('freelancer.skills.edit') }}"><i class="bi bi-tools me-2"></i> {{ __('freelancer.edit_skills') }}</a></li>
                        <li><hr class="dropdown-divider"></li>
                    @endif
                    
                    @if(session('active_role') == 'client')
                        {{-- ADDED CLIENT PROFILE LINK HERE --}}
                        <li><a class="dropdown-item py-2" href="{{ route('client.profile.show') }}"><i class="bi bi-building me-2"></i> My Company Profile</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('client.contracts.create') }}"><i class="bi bi-file-earmark-text me-2"></i> {{ __('client.create_contract') }}</a></li>
                         <li><hr class="dropdown-divider"></li>
                    @endif

                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2"><i class="bi bi-box-arrow-right me-2"></i> {{ __('common.logout') }}</button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <div class="d-flex gap-2">
                <a class="btn btn-outline-primary btn-sm px-3" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                <a class="btn btn-primary btn-sm px-3" href="{{ route('register') }}">{{ __('auth.register') }}</a>
            </div>
        @endauth
      </div>
    </div>
  </div>
</nav>

<style>
    .navbar-nav .nav-link { color: #6c757d; font-weight: 500; transition: color 0.2s; }
    .navbar-nav .nav-link:hover { color: #0d6efd; }
    .navbar-nav .nav-link.active { color: #0d6efd !important; }
</style>