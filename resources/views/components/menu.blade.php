<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/dashboard" class="brand-link">
        {{-- <img src="{{ asset('assets/img/logo.png') }}" alt="Afriloc Logo" class="brand-image img-square elevation-3"
            style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">Afriloc Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/img/logo.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name ?? 'Administrateur' }}</a>
                <small> Admin</small>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="/admin"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tableau de bord</p>
                    </a>
                </li>

                <!-- Properties -->
                <li class="nav-item {{ request()->is('admin/properties*') ? 'active' : '' }}">
                    <a href="/admin/properties"
                        class="nav-link {{ request()->is('admin/properties*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>{{ __('messages.admin.properties') }}</p>
                        <span class="badge badge-info right">{{ \App\Models\Property::count() }}</span>
                    </a>
                </li>

                <!-- Bookings -->
                <li class="nav-item {{ request()->is('admin/bookings*') ? 'active' : '' }}">
                    <a href="/admin/bookings" class="nav-link {{ request()->is('admin/bookings*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>{{ __('messages.admin.bookings') }}</p>
                        <span class="badge badge-success right">{{ \App\Models\Booking::count() }}</span>
                    </a>
                </li>

                <!-- Promoters -->
                <li class="nav-item {{ request()->is('admin/promoters*') ? 'active' : '' }}">
                    <a href="/admin/promoters"
                        class="nav-link {{ request()->is('admin/promoters*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>{{ __('messages.admin.promoters') }}</p>
                        @php
                            $pendingPromoters = \App\Models\Promoter::where('status', 'pending')->count();
                        @endphp
                        @if ($pendingPromoters > 0)
                            <span class="badge badge-warning right">{{ $pendingPromoters }}</span>
                        @endif
                    </a>
                </li>

                <!-- Contacts -->
                <li class="nav-item {{ request()->is('admin/contacts*') ? 'active' : '' }}">
                    <a href="/admin/contacts" class="nav-link {{ request()->is('admin/contacts*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>{{ __('messages.admin.contacts') }}</p>
                        <span class="badge badge-info right">{{ \App\Models\Contact::count() }}</span>
                    </a>
                </li>

                <!-- Payments -->
                <li class="nav-item {{ request()->is('admin/payments*') ? 'active' : '' }}">
                    <a href="/admin/payments" class="nav-link {{ request()->is('admin/payments*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>{{ __('messages.admin.payments') }}</p>
                        @php
                            $pendingPayments = \App\Models\Payment::where('status', 'pending')->count();
                        @endphp
                        @if ($pendingPayments > 0)
                            <span class="badge badge-warning right">{{ $pendingPayments }}</span>
                        @endif
                    </a>
                </li>


            

                <!-- Paramètres -->
                <li class="nav-item {{ request()->is('admin/parametres*') ? 'active' : '' }}">
                    <a href="" class="nav-link {{ request()->is('admin/parametres*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Paramètres</p>
                    </a>
                </li>

                <!-- Exemples UI (pour développement) -->
                <li class="nav-item {{ request()->is('admin/exemples*') ? 'active' : '' }}">
                    <a href="/admin/exemples/ui-elements"
                        class="nav-link {{ request()->is('admin/exemples*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-palette"></i>
                        <p>Exemples UI</p>
                        <span class="badge badge-info right">Demo</span>
                    </a>
                </li>

                <!-- Déconnexion -->
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Déconnexion</p>
                    </a>
                    <form id="logout-form" action="/admin/logout" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
