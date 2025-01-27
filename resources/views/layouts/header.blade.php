<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield("title")</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet"  href="{{ asset('assets/css/searchableOptionList.css') }}">
</head>

<style>
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
            <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('dashboard')}}" aria-expanded="false">
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
                <a class="sidebar-link" href="{{ url('/rbac/users') }}" aria-expanded="false">
                  <span>
                    <i class="ti ti-users"></i>
                  </span>
                  <span class="hide-menu">Users</span>
                </a>
              </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{ url('/rbac/roles') }}" aria-expanded="false">
                <span>
                  <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">Roles</span>
              </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ url('/rbac/permissions') }}" aria-expanded="false">
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
              <a class="sidebar-link" href="{{route('categories.index')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-folder"></i>
                </span>
                <span class="hide-menu">Kategori Dokumen</span>
              </a>
            </li>
            @endcan
            @can('active-document')
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('document.active')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-file"></i>
                </span>
                <span class="hide-menu">Dokumen Aktif</span>
              </a>
            </li>
            @endcan
            @can('view-revisions')
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('document_revision.index')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-pencil"></i>
                </span>
                <span class="hide-menu">Revisi Dokumen</span>
              </a>
            </li>
            @endcan
            @can('view-approval')
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('document_approval.index')}}" aria-expanded="false">
                <span>
                  <i class="ti ti-checks"></i>
                </span>
                <span class="hide-menu">Pengesahan Dokumen</span>
              </a>
            </li>
            @endcan
            @can('view-histories')
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('document_histories.index')}}" aria-expanded="false">
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
              <a class="sidebar-link" href="javascript:void(0);" aria-expanded="false" onclick="document.getElementById('logout-form').submit();">
                <span>
                  <i class="ti ti-login"></i>
                </span>
                <span class="hide-menu">Log Out</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <!-- Dropdown Notify Section Start -->
            <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <i class="ti ti-bell-ringing"></i>
                  <div class="notification bg-primary rounded-circle"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up start-50 dropdown-width" aria-labelledby="drop2">
                <div class="notification-body">
                <div class="d-flex justify-content-between align-items-center p-2">
                  <p class="text-dark fw-bold fs-5 mb-0">Notifikasi</p>
                  <a href="/admin/notifikasi_admin" class="text-primary fs-4 fw-bold" id="view-all-notifications">Lihat semua</a>
                </div>
                <hr>
                <!-- Notify Start -->
                  <div id="notification-list" class="notification-container">
                    <p id="no-notifications" class="text-muted text-center" style="display: none;">Tidak ada notifikasi baru</p>
                    <!-- Notifikasi Dummy -->
                    @if (count(auth()->user()->unreadNotifications) > 0)
                      @foreach (auth()->user()->unreadNotifications as $notification)
                        <div id="notify-items" class="dclose notification-item highlight">
                          <a href="{{$notification->data['link']}}" class="text-dark">{{$notification->data['message']}}</a>
                        </div>
                      @endforeach
                    </div>
                    <hr>
                    <div class="d-flex justify-content-center align-items-center">
                      <button class="btn btn-outline-secondary dclose" id="mark-read">Tandai semua telah dibaca</button>
                    </div>
                  @else
                  <div id="notify-items" class="dclose notification-item align-items-center">
                    <p>Tidak Ada Notifikasi Baru.</p>
                  </div>
                  @endif
                <!-- Notify End -->
                </div>
              </li>
            </ul>
          </div>
          <!-- Dropdown Notify Section End -->
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    <a href="javascript:void()" class="btn btn-outline-primary mx-3 mt-2 d-block" onclick="document.getElementById('logout-form').submit();">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->

      <script>
        // Fungsi baca pesan
        document.querySelectorAll('.notification-item').forEach(item => {
          item.addEventListener('click', () => {
            item.classList.remove('highlight');
          });
        });

         // Fungsi baca semua
        document.getElementById('mark-read').addEventListener('click', () => {
          document.querySelectorAll('.notification-item').forEach(item => {
            item.classList.remove('highlight');
          });
        });

        // Fungsi biar ga nutup dropdown
        document.querySelectorAll('.dclose').forEach(item => {
          item.addEventListener('click', (event) => {
            event.stopPropagation();
          });
        });
      </script>
