<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logoupt.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/searchableOptionList.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<style>
    #notificationDropdown {
        max-height: 400px; /* Set a maximum height for the dropdown */
        overflow-y: auto;  /* Make the dropdown scrollable */
    }

  .dropdown-width {
      width: 400px;
  }

  .notification-item {
      padding: 10px;
      border: 1px solid #ddd;
      margin-bottom: 10px;
  }

  .highlight {
      background-color: #f0f8ff;
  }

  .notification-time{
    font-size: 0.75rem;
    color: gray;
  }
</style>

<body>

    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="/" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/images/logos/sidebar.png') }}" width="215" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                @if (auth()->user()->isRole('kepala-puskesmas') || auth()->user()->isRole('administrator'))
                    <nav class="sidebar-nav-admin scroll-sidebar" data-simplebar="">
                    @elseif (auth()->user()->isRole('pj-program') || auth()->user()->isRole('staff'))
                        <nav class="sidebar-nav-user scroll-sidebar" data-simplebar="">
                        @else
                            <nav class="sidebar-nav-approver scroll-sidebar" data-simplebar="">
                @endif
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link @if (Str::contains(request()->url(), 'dashboard')) active @endif"
                            href="{{ route('dashboard') }}" aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    @can('administrate')
                        <li class="nav-small-cap">
                            <i class="ti ti-user nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">USER</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link @if (Str::contains(request()->url(), 'users')) active @endif"
                                href="{{ url('/rbac/users') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-users"></i>
                                </span>
                                <span class="hide-menu">Users</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link @if (Str::contains(request()->url(), 'roles')) active @endif"
                                href="{{ url('/rbac/roles') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user"></i>
                                </span>
                                <span class="hide-menu">Roles</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link @if (Str::contains(request()->url(), 'permissions')) active @endif"
                                href="{{ url('/rbac/permissions') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user"></i>
                                </span>
                                <span class="hide-menu">Permission</span>
                            </a>
                        </li>
                    @endcan
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Dokumen</span>
                    </li>
                    @can('manage-categories')
                        <li class="sidebar-item">
                            <a class="sidebar-link @if (Str::contains(request()->url(), 'categories')) active @endif"
                                href="{{ route('categories.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-tag"></i>
                                </span>
                                <span class="hide-menu">Kategori Dokumen</span>
                            </a>
                        </li>
                    @endcan
                    @can('active-document')
                        <li class="sidebar-item">
                            <a class="sidebar-link @if (Str::contains(request()->url(), 'active_document')) active @endif"
                                href="{{ route('document.active') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-file"></i>
                                </span>
                                <span class="hide-menu">Dokumen</span>
                            </a>
                        </li>
                    @endcan
                    @can('view-revisions')
                        <li class="sidebar-item">
                            <a class="sidebar-link @if (Str::contains(request()->url(), ['documents/create', 'document_revision'])) active @endif"
                                href="{{ route('document_revision.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-folder"></i>
                                </span>
                                <span class="hide-menu">Dokumen Anda</span>
                            </a>
                        </li>
                    @endcan
                    @can('view-approval')
                        <li class="sidebar-item">
                            <a class="sidebar-link @if (Str::contains(request()->url(), 'document_approval')) active @endif"
                                href="{{ route('document_approval.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-checks"></i>
                                </span>
                                <span class="hide-menu">Pengesahan Dokumen</span>
                            </a>
                        </li>
                    @endcan
                    @can('view-histories')
                        <li class="sidebar-item">
                            <a class="sidebar-link @if (Str::contains(request()->url(), 'document_histories')) active @endif"
                                href="{{ route('document_histories.index') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-history"></i>
                                </span>
                                <span class="hide-menu">Riwayat Dokumen</span>
                            </a>
                        </li>
                    @endcan
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">AUTH</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="javascript:void(0);" aria-expanded="false"
                            onclick="document.getElementById('logout-form').submit();">
                            <span>
                                <i class="ti ti-login"></i>
                            </span>
                            <span class="hide-menu">Log Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <!-- Dropdown Notify Section Start -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link nav-icon-hover position-relative " href="javascript:void(0)" id="drop"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-bell-ringing"></i>
                                        @if (count(auth()->user()->unreadNotifications) > 0)
                                          <span id="unread-notification-count" class="position-absolute start-100 translate-middle badge rounded-pill bg-admin">
                                            {{count(auth()->user()->unreadNotifications)}}
                                            <span class="visually-hidden">unread messages</span>
                                          </span>
                                        @endif
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up start-50 dropdown-width p-1"
                                        aria-labelledby="drop" id="notificationDropdown">
                                        <div class="notification-body">
                                            <div class="d-flex justify-content-between align-items-center p-2">
                                                <p class="text-dark fw-bold fs-5 mb-0">Notifikasi</p>
                                                <a href="javascript:void()" id="mark-read" class="text-primary fs-4 fw-bold"
                                                    >Tandai Semua Dibaca</a>
                                            </div>
                                            <hr>
                                            <!-- Notify Start -->
                                            <div id="notification-list" class="notification-container">
                                                <!-- Notifikasi Dummy -->
                                                @if (count(auth()->user()->unreadNotifications) > 0)
                                                    @foreach (auth()->user()->unreadNotifications->sortByDesc('created_at')->take(5) as $notification)
                                                        <div id="notify-items" class="dclose notification-item highlight" data-notification-id="{{ $notification->id }}">
                                                            <a href="{{ $notification->data['link'] }}" class="text-dark">
                                                                <span class="notification-time">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13a7 7 0 1 0 14 0a7 7 0 0 0 -14 0z" /><path d="M14.5 10.5l-2.5 2.5" /><path d="M17 8l1 -1" /><path d="M14 3h-4" /></svg>
                                                                    ({{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }})
                                                                </span>
                                                                <br>
                                                                {{ $notification->data['message'] }}
                                                            </a>
                                                        </div>
                                                    @endforeach
                                            </div>
                                        @else
                                            <div id="notify-items"
                                                class="dclose notification-item d-flex justify-content-center">
                                                <p>Tidak Ada Notifikasi Baru.</p>
                                            </div>
                                        @endif
                                        <hr>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="{{route('notifications')}}" class="btn btn-outline-secondary dclose mb-2" id="view-all-notifications">Lihat Semua</a>
                                        </div>
                                        <!-- Notify End -->
                                        </div>
                                    </div>
                                </li>
                        <!-- Dropdown Notify Section End -->
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover-admin" href="{{route('profile')}}">
                                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt=""
                                        width="35" height="35" class="rounded-circle">
                                </a>
                               
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
