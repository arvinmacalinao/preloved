<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent ">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
            <a class="navbar-brand" href="{{ route('dashboard')}} "><i class="fa fa-bars" aria-hidden="true"></i></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
            aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            {{-- <form>
                <div class="input-group no-border">
                    <input type="text" value="" class="form-control" placeholder="Search...">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="nc-icon nc-zoom-split"></i>
                        </div>
                    </div>
                </div>
            </form> --}}
            <ul class="navbar-nav">
                <li class="nav-item btn-rotate dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="nc-icon nc-bell-55"></i>
                        <p>
                            <span class="d-lg-none d-md-block">{{ __('Notifications') }}</span>
                        </p>
                        <!-- Display the total number of unsold and sold notifications -->
                        @php
                            $totalUnsoldNotifications = $notifications->where('not_type_id', 1)->where('read_at', null)->count();
                            $totalSoldNotifications = $notifications->where('not_type_id', 2)->where('read_at', null)->count();
                            $allnotification = $notifications->count();
                            $totalNotifications = $totalUnsoldNotifications + $totalSoldNotifications;
                        @endphp
                        @if($totalNotifications >= 1)
                            <span class="badge badge-danger">{{ $totalNotifications }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown">
                        <a class="dropdown-item" href="{{ route('notification.list.unsold') }}">{{ __('Unsold Notifications') }} ({{ $totalUnsoldNotifications }})</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('notification.list.sold') }}">{{ __('Sold Notifications') }} ({{ $totalSoldNotifications }})</a>
                        <div class="dropdown-divider"></div>
                        {{-- {{ route('notifications.index') }} --}}
                        <a class="dropdown-item" href="{{ route('notification.list') }}">
                            {{ __('View Notifications') }} ({{ $allnotification }})
                        </a>
                    </div>
                </li>                
                <li class="nav-item btn-rotate dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="nc-icon nc-settings-gear-65"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink2">
                        <form class="dropdown-item" action="{{ route('logout') }}" id="formLogOut" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <div class="dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">{{ Auth::user()->fullname }}</a>
                            <a class="dropdown-item" onclick="document.getElementById('formLogOut').submit();">{{ __('Log out') }}</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
