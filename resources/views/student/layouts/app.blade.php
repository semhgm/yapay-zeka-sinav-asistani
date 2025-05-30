<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="route-exams-store" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    @stack('styles')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <!-- FullCalendar Light Theme CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- AdminLTE 3.2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">

    <!-- Navbar -->

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <!-- Bildirim (Zil) -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>

            <!-- Kullanıcı Profil Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" role="button">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6c63ff&color=fff&rounded=true&size=32"
                         alt="User Avatar"
                         class="img-circle elevation-2"
                         style="width: 32px; height: 32px;">
                    <span class="ml-1">{{ auth()->user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Profilim
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="GET" class="dropdown-item p-0">
                        <button type="submit" class="btn btn-link btn-block text-left text-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i> Çıkış Yap
                        </button>
                    </form>
                </div>
            </li>


        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        @auth
            <!-- Kullanıcı Paneli (İkonlu) -->
            <div class="sidebar user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                <div class="image">
                    <i class="fas fa-user-circle fa-2x text-white"></i>
                </div>
                <div class="info ms-2">
                    <a href="#" class="d-block text-white">{{ auth()->user()->name }}</a>
                </div>
            </div>
        @endauth
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{route('student.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Sınavlar -->
                        <li class="nav-item">
                            <a href="{{route('student.exams.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>Sınavlar</p>
                            </a>
                        </li>

                        <!-- Sınav Analizleri -->
                        <li class="nav-item">
                            <a href="{{route('student.exams.analysis')}}" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Analizler</p>
                            </a>
                        </li>

                        <!-- Notlarım -->
                        <li class="nav-item">
                            <a href="{{route('student.notes.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Notlarım</p>
                            </a>
                        </li>

                        <!-- Çalışma Programı -->
                        <li class="nav-item">
                            <a href="{{route('student.schedule.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>Çalışma Programı</p>
                            </a>
                        </li>

                        <!-- Takvim -->
                        <li class="nav-item">
                            <a href="{{route('student.calendar.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Takvim</p>
                            </a>
                        </li>

                        <!-- Bildirimler (Ekstra öneri) -->
                        <li class="nav-item">
                            <a href="{{route('student.notifications.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-bell"></i>
                                <p>Bildirimler</p>
                            </a>
                        </li>


                        <!-- Destek (Ekstra öneri) -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-life-ring"></i>
                                <p>Destek</p>
                            </a>
                        </li>

                        <!-- Kullanıcı Ayarları -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>Hesap Ayarları</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
    </aside>
    <!-- Content -->
    <div class="content-wrapper p-3">
        @yield('content')
    </div>

</div>
<!-- Required JavaScripts -->
{{-- jQuery (make sure version is compatible with your Bootstrap version) --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script> {{-- If using Bootstrap 4 styling --}}
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>


@stack('scripts')
<div class="toasts-top-right fixed position-fixed p-3" style="z-index: 9999; top: 1rem; right: 1rem;"></div>
</body>
</html>
