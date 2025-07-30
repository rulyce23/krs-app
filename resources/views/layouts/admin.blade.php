<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - SIMAK</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }
        
        /* Sidebar */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 10%, #224abe 100%);
            color: white;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
            transition: all 0.3s;
        }
        
        .sidebar-brand {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 800;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .sidebar-heading {
            padding: 0 1rem;
            font-weight: 800;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }
        
        .sidebar-item {
            padding: 0.5rem 1rem;
        }
        
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 0.35rem;
            transition: all 0.3s;
        }
        
        .sidebar-link:hover, .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .sidebar-link i {
            margin-right: 0.5rem;
            width: 1.5rem;
            text-align: center;
        }
        
        /* Content */
        .content-wrapper {
            margin-left: 250px;
            padding: 1rem;
            min-height: 100vh;
        }
        
        /* Topbar */
        .topbar {
            height: 70px;
            background-color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            margin-bottom: 1.5rem;
        }
        
        .topbar-divider {
            width: 0;
            border-right: 1px solid #e3e6f0;
            height: 2rem;
            margin: auto 1rem;
        }
        
        /* Cards */
        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            border: none;
            border-radius: 0.35rem;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .card-header h6 {
            font-weight: 700;
            margin: 0;
        }
        
        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        
        /* Tables */
        .table th {
            background-color: #f8f9fc;
            font-weight: 700;
            color: var(--dark-color);
        }
        
        /* Toggle Sidebar */
        #sidebarToggle {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            border-radius: 50%;
            width: 2.5rem;
            height: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        #sidebarToggle:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100px;
            }
            
            .sidebar-brand {
                font-size: 0.9rem;
                padding: 0 0.5rem;
            }
            
            .sidebar-brand span {
                display: none;
            }
            
            .sidebar-link span {
                display: none;
            }
            
            .content-wrapper {
                margin-left: 100px;
            }
        }
        
        /* Collapsed Sidebar */
        .sidebar-collapsed .sidebar {
            width: 100px;
        }
        
        .sidebar-collapsed .sidebar-brand span {
            display: none;
        }
        
        .sidebar-collapsed .sidebar-link span {
            display: none;
        }
        
        .sidebar-collapsed .content-wrapper {
            margin-left: 100px;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <i class="fas fa-graduation-cap me-2"></i>
                <span>SIMAK Admin</span>
            </div>
            
            <div class="sidebar-menu">
                <div class="sidebar-heading">Core</div>
                
                <div class="sidebar-item">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="sidebar-heading">Akademik</div>
                
                <div class="sidebar-item">
                    <a href="{{ route('admin.courses.index') }}" class="sidebar-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Mata Kuliah</span>
                    </a>
                </div>
                
                <div class="sidebar-item">
                    <a href="{{ route('admin.krs.index') }}" class="sidebar-link {{ request()->routeIs('admin.krs.*') ? 'active' : '' }}">
                        <i class="fas fa-fw fa-list"></i>
                        <span>KRS Submissions</span>
                    </a>
                </div>
                
                <div class="sidebar-heading">Manajemen User</div>
                
                <div class="sidebar-item">
                    <a href="{{ route('admin.users.students.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.students.*') ? 'active' : '' }}">
                        <i class="fas fa-fw fa-user-graduate"></i>
                        <span>Mahasiswa</span>
                    </a>
                </div>
                
                <div class="sidebar-item">
                    <a href="{{ route('admin.users.admins.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.admins.*') ? 'active' : '' }}">
                        <i class="fas fa-fw fa-user-tie"></i>
                        <span>Admin/Koordinator</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Topbar -->
            <div class="topbar">
                <button id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="d-flex align-items-center">
                    <div class="text-muted">
                        Selamat datang, <strong>{{ Auth::guard('admin')->user()->name }}</strong>
                    </div>
                    
                    <div class="topbar-divider"></div>
                    
                    <div class="dropdown">
                        <a class="btn btn-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Toggle Sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-collapsed');
        });
        
        // Initialize DataTables
        $(document).ready(function() {
            $('.datatable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json'
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>