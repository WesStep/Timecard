<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        @if(!Auth::check())
        <a class="navbar-brand" href="{{ route('index') }}">
            <img src="{{ URL::to('/images/icon.png') }}" height="64" width="64" alt="Example Logo">
        </a>
        @else
        <a class="navbar-brand" href="{{ route('dashboard/index') }}">
            <img src="{{ URL::to('/images/icon.png') }}" height="64" width="64" alt="Example Logo">
        </a>
        @endif
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="navbar-nav mr-auto">
                @if(Auth::check())
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('dashboard/index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('dashboard/edit') }}">Edit Info</a>
                </li>
                @if($role[0] == 'employee')
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('dashboard/clock') }}">Clock In/Out</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('dashboard/history') }}">Work History</a>
                </li>
                @endif
                @if($role[0] == 'payroll admin' || $role[0] == 'business owner')
                <!-- <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('dashboard/manage') }}">Manage Accounts</a>
                </li> -->
                @endif
                @if($role[0] == 'payroll admin')
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('dashboard/pay') }}">Manage Shifts</a>
                </li>
                @elseif($role[0] == 'business owner')
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('dashboard/company') }}">Manage Companies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('dashboard/statistics') }}">Business Stats</a>
                </li>
                @endif
            </ul>
            <ul class="navbar-nav navbar-right">
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
            @endif
        </div>
    </nav>
</header>
