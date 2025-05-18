<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="route-exams-store" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <!-- AdminLTE 3.2 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.3.0/js/dataTables.min.js"></script>
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="bi bi-list"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto"> <!-- sağ taraf -->
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="GET" class="d-inline">
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Çıkış Yap
                    </button>
                </form>
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
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-clipboard-list"></i>
                                <p>Notlarım</p>
                            </a>
                        </li>

                        <!-- Çalışma Programı -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>Çalışma Programı</p>
                            </a>
                        </li>

                        <!-- Takvim -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Takvim</p>
                            </a>
                        </li>

                        <!-- Bildirimler (Ekstra öneri) -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Popper.js (Needed for Bootstrap 4 tooltips, popovers, etc., often included in bundle) --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script> --}}
{{-- OR use the bundle which includes Popper --}}

{{-- Bootstrap JS --}}
{{-- Or if using separate files: <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script> --}}

{{-- DataTables JS (Assuming you're using DataTables based on $('#examTable').DataTable()) --}}
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script> {{-- If using Bootstrap 4 styling --}}
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>
