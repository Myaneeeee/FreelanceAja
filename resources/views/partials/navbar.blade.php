<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('landing') }}">FreelanceAja</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="freelancerMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Freelancer
          </a>
          <ul class="dropdown-menu" aria-labelledby="freelancerMenu">
            <li><a class="dropdown-item" href="{{ route('freelancer.home') }}">Home</a></li>
            <li><a class="dropdown-item" href="{{ route('freelancer.jobs.index') }}">Browse Jobs</a></li>
            <li><a class="dropdown-item" href="{{ route('freelancer.contracts.index') }}">Contracts</a></li>
            <li><a class="dropdown-item" href="{{ route('freelancer.profile.show') }}">Profile</a></li>
            <li><a class="dropdown-item" href="{{ route('freelancer.skills.edit') }}">Edit Skills</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown ms-lg-3">
          <a class="nav-link dropdown-toggle" href="#" id="clientMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Client
          </a>
          <ul class="dropdown-menu" aria-labelledby="clientMenu">
            <li><a class="dropdown-item" href="{{ route('client.home') }}">Home</a></li>
            <li><a class="dropdown-item" href="{{ route('client.jobs.create') }}">Post a Job</a></li>
            <li><a class="dropdown-item" href="{{ route('client.jobs.index') }}">My Jobs</a></li>
            <li><a class="dropdown-item" href="{{ route('client.contracts.create') }}">Create Contract</a></li>
          </ul>
        </li>
      </ul>
        <div class="d-flex align-items-center gap-2">
        @auth
            <span class="text-light me-2">Hi, {{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        @else
            <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">Sign In</a>
            <a class="btn btn-light btn-sm" href="{{ route('register') }}">Sign Up</a>
        @endauth
      </div>
    </div>
  </div>
</nav>
