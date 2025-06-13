<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Gudang Kita</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom CSS for Stunning UI -->
    <style>
        /* Variabel CSS untuk warna dan font */
        :root {
            --bs-primary-rgb: 74, 105, 226;
            --bs-primary: #4A69E2;
            --bs-secondary: #6c757d;
            --bs-light: #f8f9fa;
            --bs-dark: #343a40;
            --bs-font-sans-serif: 'Inter', sans-serif;
            --bs-body-bg: #F7F8FC;
            --sidebar-width: 260px;
        }

        /* Styling body halaman */
        body {
            font-family: var(--bs-font-sans-serif);
            background-color: var(--bs-body-bg);
            color: #334155;
        }

        /* Wrapper utama yang membungkus sidebar dan konten */
        .wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Sidebar navigasi */
        #sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background: #ffffff;
            color: #475569;
            transition: all 0.3s;
            box-shadow: 0 0 30px rgba(0,0,0,0.05);
            position: fixed;
            height: 100%;
            z-index: 1000;
            display: block !important;
        }
        /* Konten utama halaman */
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* Header sidebar */
        #sidebar .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }
        
        /* Logo aplikasi di sidebar */
        #sidebar .sidebar-header .app-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--bs-primary);
            text-decoration: none;
        }

        /* Daftar menu di sidebar */
        #sidebar ul.components {
            padding: 20px 0;
        }

        /* Judul grup menu */
        #sidebar ul p {
            color: #94a3b8;
            padding: 10px 30px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Link menu */
        #sidebar ul li a {
            padding: 12px 30px;
            font-size: 0.95rem;
            display: block;
            color: #475569;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            border-left: 4px solid transparent;
            text-decoration: none;
        }

        /* Efek hover pada link menu */
        #sidebar ul li a:hover {
            background: #f1f5f9;
            color: var(--bs-primary);
        }

        /* Link menu aktif */
        #sidebar ul li.active > a, a[aria-expanded="true"] {
            color: var(--bs-primary);
            background: #f1f5f9;
            border-left: 4px solid var(--bs-primary);
        }

        /* Ikon pada link menu */
        #sidebar ul li a i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        /* Styling konten utama */
        #content {
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* Styling kartu */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02), 0 1px 3px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }
        
        /* Styling badan kartu statistik */
        .stat-card .card-body {
            display: flex;
            align-items: center;
        }
        
        /* Ikon pada kartu statistik */
        .stat-card .icon {
            font-size: 2rem;
            padding: 1.25rem;
            border-radius: 50%;
            margin-right: 1.5rem;
            color: #fff;
        }

        /* Styling tombol logout */
        .btn-logout-link {
            padding: 12px 30px !important;
            font-size: 0.95rem !important;
            color: #475569 !important;
            font-weight: 500 !important;
        }
         /* Efek hover tombol logout */
         .btn-logout-link:hover {
            background: #f1f5f9 !important;
            color: var(--bs-primary) !important;
        }

    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <!-- Logo aplikasi yang mengarah ke halaman dashboard produk -->
                <a class="app-logo" href="{{ route('produk.index') }}"><i class="fas fa-cubes-stacked"></i> Gudang Kita</a>
            </div>

            <ul class="list-unstyled components">
                <!-- Judul menu utama -->
                <p>Menu Utama</p>
                <!-- Menu Dashboard -->
                <li class="{{ Route::is('produk.index') ? 'active' : '' }}">
                    <a href="{{ route('produk.index') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <!-- Menu Tambah Produk -->
                <li class="{{ Route::is('produk.create') ? 'active' : '' }}">
                    <a href="{{ route('produk.create') }}"><i class="fas fa-plus-circle"></i> Tambah Produk</a>
                </li>
                <!-- Menu Laporan -->
                <li class="{{ Route::is('produk.laporan') ? 'active' : '' }}">
                    <a href="{{ route('produk.laporan') }}"><i class="fas fa-chart-line"></i> Laporan</a>
                </li>

                <!-- Judul grup menu akun -->
                <p>Akun</p>
                <!-- Tombol logout -->
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none w-100 text-start btn-logout-link">
                           <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Konten halaman utama -->
        <div id="content">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
