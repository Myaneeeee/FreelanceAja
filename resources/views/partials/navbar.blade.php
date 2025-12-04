<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('landing') }}">FreelanceAja</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @auth
            @if(session('active_role') == 'freelancer')
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="freelancerMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ __('common.home') }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="freelancerMenu">
                    <li><a class="dropdown-item" href="{{ route('freelancer.home') }}">{{ __('freelancer.dashboard') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('freelancer.jobs.index') }}">{{ __('freelancer.browse_jobs') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('freelancer.contracts.index') }}">{{ __('freelancer.my_contracts') }}</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('freelancer.profile.show') }}">{{ __('freelancer.my_profile') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('freelancer.skills.edit') }}">{{ __('freelancer.edit_skills') }}</a></li>
                </ul>
                </li>
            @endif

            @if(session('active_role') == 'client')
                <li class="nav-item dropdown ms-lg-3">
                <a class="nav-link dropdown-toggle" href="#" id="clientMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ __('client.client') }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="clientMenu">
                    <li><a class="dropdown-item" href="{{ route('client.home') }}">{{ __('client.dashboard') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('client.jobs.create') }}">{{ __('client.post_new_job') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('client.jobs.index') }}">{{ __('client.my_job_postings') }}</a></li>
                    <li><a class="dropdown-item" href="{{ route('client.contracts.create') }}">{{ __('client.create_contract') }}</a></li>
                </ul>
                </li>
            @endif
        @endauth
      </ul>

      <div class="d-flex align-items-center gap-2">
        {{-- Language Switcher --}}
        <div class="btn-group" role="group">
            <a href="{{ route('locale.set', 'en') }}" class="btn btn-sm {{ app()->getLocale() == 'en' ? 'btn-light' : 'btn-outline-light' }}" title="English">
                EN
            </a>
            <a href="{{ route('locale.set', 'id') }}" class="btn btn-sm {{ app()->getLocale() == 'id' ? 'btn-light' : 'btn-outline-light' }}" title="Indonesian">
                ID
            </a>
        </div>

        @auth
            <div class="dropdown">
                <a href="#" class="text-light text-decoration-none dropdown-toggle d-flex align-items-center gap-2" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>{{ __('common.home') }}, {{ Auth::user()->name }}</span>
                    {{-- Role Badge --}}
                    <span class="badge bg-light text-primary text-uppercase" style="font-size: 0.7rem;">
                        {{ session('active_role', 'Freelancer') }}
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">{{ __('common.logout') }}</button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">{{ __('auth.login') }}</a>
            <a class="btn btn-light btn-sm" href="{{ route('register') }}">{{ __('auth.register') }}</a>
        @endauth
      </div>

    </div>
  </div>
</nav>