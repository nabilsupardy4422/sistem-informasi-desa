<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SI Desa Premium</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: #FFFFFF;
            --main-bg: #F8FAFC;
            --primary: #4F46E5;
            --primary-light: #EEF2FF;
            --text-main: #1E293B;
            --text-muted: #64748B;
            --border-color: #F1F5F9;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--main-bg);
            color: var(--text-main);
            overflow-x: hidden;
        }

        .font-display {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* --- MODERN WHITE SIDEBAR --- */
        .sidebar {
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            box-shadow: 10px 0 40px rgba(0, 0, 0, 0.02);
            z-index: 50;
        }

        .sidebar-brand {
            border-bottom: 1px solid var(--border-color);
            background: var(--sidebar-bg);
        }

        /* --- NAV ITEMS --- */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-muted);
            position: relative;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 4px;
        }

        .nav-item i {
            width: 18px;
            height: 18px;
            stroke-width: 2.2px;
        }

        .nav-item:hover {
            background: var(--primary-light);
            color: var(--primary);
        }

        .nav-active {
            background: var(--primary-light);
            color: var(--primary) !important;
        }

        /* Nav Indicator (Dot on active) */
        .nav-active::after {
            content: '';
            position: absolute;
            right: 12px;
            width: 5px;
            height: 5px;
            background: var(--primary);
            border-radius: 50%;
        }

        /* --- TOOLTIP --- */
        .tooltip {
            position: absolute;
            left: 80px;
            background: #1E293B;
            color: #FFF;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            opacity: 0;
            pointer-events: none;
            white-space: nowrap;
            z-index: 100;
            transform: translateX(-10px);
            transition: all 0.2s ease;
        }

        /* --- SIDEBAR COLLAPSED LOGIC --- */
        .sidebar-collapsed {
            width: 88px !important;
        }
        .sidebar-collapsed .sidebar-text,
        .sidebar-collapsed .nav-active::after,
        .sidebar-collapsed .brand-text,
        .sidebar-collapsed .version-card {
            display: none;
        }
        .sidebar-collapsed .nav-item {
            justify-content: center;
            padding: 12px;
            margin: 0 12px 8px 12px;
        }
        .sidebar-collapsed .nav-item:hover .tooltip {
            opacity: 1;
            transform: translateX(0);
        }
        .sidebar-collapsed .brand-icon {
            margin: 0 auto;
        }
        .sidebar-collapsed .sidebar-group-label {
            text-align: center;
            margin-left: 0;
            font-size: 10px;
        }

        /* --- HEADER --- */
        .header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
        }

        /* --- GLASS BUTTONS --- */
        .btn-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.2s ease;
            background: #fff;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
        }
        .btn-icon:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary-light);
            transform: translateY(-1px);
        }

        /* --- SCROLLBAR --- */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }

        * { transition: background-color 0.2s, border-color 0.2s, color 0.2s; }
    </style>
</head>

<body class="flex selection:bg-indigo-100 selection:text-indigo-700">

    <aside id="sidebar" class="sidebar w-72 h-screen fixed left-0 top-0 overflow-y-auto transition-all duration-300 flex flex-col">

        <div class="sidebar-brand sticky top-0 px-6 py-7 flex items-center gap-3.5 z-10">
            <div class="brand-icon w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-200 shrink-0">
                <i data-lucide="component" class="w-6 h-6"></i>
            </div>
            <div class="brand-text whitespace-nowrap">
                <h1 class="text-xl font-display font-extrabold text-slate-800 tracking-tight">
                    SI <span class="text-indigo-600">Desa</span>
                </h1>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold mt-0.5">
                    Sistem Informasi Desa
                </p>
            </div>
        </div>

        <nav class="px-4 py-6 space-y-1 flex-grow">

            <p class="sidebar-group-label text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em] mb-4 ml-4 mt-2">Main Menu</p>

            <a href="/admin/dashboard" class="nav-item {{ request()->is('admin/dashboard') ? 'nav-active' : '' }}">
                <i data-lucide="layout-grid"></i>
                <span class="sidebar-text">Dashboard</span>
                <span class="tooltip">Dashboard</span>
            </a>

            <p class="sidebar-group-label text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em] mb-4 ml-4 mt-8">Service</p>

            <a href="/admin/layanan" class="nav-item {{ request()->is('admin/layanan*') ? 'nav-active' : '' }}">
                <i data-lucide="box"></i>
                <span class="sidebar-text">Katalog Layanan</span>
                <span class="tooltip">Katalog Layanan</span>
            </a>

            <a href="/admin/permohonan" class="nav-item {{ request()->is('admin/permohonan*') ? 'nav-active' : '' }}">
                <i data-lucide="file-text"></i>
                <span class="sidebar-text">Permohonan</span>
                <span class="tooltip">Permohonan</span>
            </a>

            <a href="/admin/pengaduan" class="nav-item {{ request()->is('admin/pengaduan*') ? 'nav-active' : '' }}">
                <i data-lucide="alert-circle"></i>
                <span class="sidebar-text">Pengaduan</span>
                <span class="tooltip">Pengaduan</span>
            </a>

            <a href="/admin/tracking" class="nav-item {{ request()->is('admin/tracking*') ? 'nav-active' : '' }}">
                <i data-lucide="map-pin"></i>
                <span class="sidebar-text">Sistem Tracking</span>
                <span class="tooltip">Sistem Tracking</span>
            </a>

            <p class="sidebar-group-label text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.15em] mb-4 ml-4 mt-8">Information</p>

            <a href="/admin/apbdes" class="nav-item {{ request()->is('admin/apbdes*') ? 'nav-active' : '' }}">
                <i data-lucide="bar-chart-3"></i>
                <span class="sidebar-text">Data APBDes</span>
                <span class="tooltip">Data APBDes</span>
            </a>
            <a href="/admin/berita" class="nav-item {{ request()->is('admin/berita*') ? 'nav-active' : '' }}">
                <i data-lucide="rss"></i>
                <span class="sidebar-text">Portal Berita</span>
                <span class="tooltip">Portal Berita</span>
            </a>

            <a href="/admin/penduduk" class="nav-item {{ request()->is('admin/penduduk*') ? 'nav-active' : '' }}">
                <i data-lucide="user-check"></i>
                <span class="sidebar-text">Data Penduduk</span>
                <span class="tooltip">Data Penduduk</span>
            </a>

            <a href="/admin/umkm" class="nav-item {{ request()->is('admin/umkm*') ? 'nav-active' : '' }}">
                <i data-lucide="shopping-bag"></i>
                <span class="sidebar-text">Direktori UMKM</span>
                <span class="tooltip">Direktori UMKM</span>
            </a>

        </nav>

        <div class="p-6 mt-auto">
            <div class="version-card bg-slate-50 border border-slate-100 rounded-2xl p-4 text-center">
                <p class="text-[10px] text-slate-500 font-bold tracking-tight">Copy Right.</p>
                <p class="text-[9px] text-slate-400 mt-1 uppercase font-bold tracking-widest">Managed by Nabil Adillah Supardy</p>
            </div>
        </div>

    </aside>

    <div id="mainContent" class="ml-72 w-full min-h-screen transition-all duration-300 flex flex-col">

        <header class="header sticky top-0 z-40 px-8 py-4 flex items-center justify-between">

            <div class="flex items-center gap-6">
                <button onclick="toggleSidebar()" class="btn-icon">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>

                <div class="hidden sm:block">
                    <h2 class="font-display font-bold text-slate-800 text-base leading-none">
                        Overview Analytics
                    </h2>
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider mt-1.5">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-5">

                <a href="/" target="_blank" class="hidden md:flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-indigo-600 transition-colors bg-white border border-slate-200 px-4 py-2.5 rounded-xl shadow-sm">
                    <i data-lucide="globe" class="w-4 h-4"></i> Visit Site
                </a>

                <div class="hidden sm:block h-6 w-px bg-slate-200 mx-1"></div>

                <div class="flex items-center gap-3 px-1 py-1 rounded-full">
                    <div class="text-right hidden sm:block">
                        <p class="font-bold text-xs text-slate-800 leading-tight">
                            Administrator
                        </p>
                        <p class="text-[9px] uppercase tracking-widest text-emerald-500 font-black mt-0.5">
                            Online
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 text-slate-600 flex items-center justify-center font-bold text-sm shadow-sm ring-2 ring-white">
                        AD
                    </div>
                </div>

                <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="btn-icon border-rose-100 text-rose-500 hover:bg-rose-500 hover:text-white" title="Logout">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </button>
                </form>

            </div>

        </header>

        <main class="p-6 md:p-10 flex-grow">
            @yield('content')
        </main>

        <footer class="px-10 py-6 text-slate-400 text-[11px] font-bold uppercase tracking-widest mt-auto border-t border-slate-100 flex justify-between items-center">
            <span>&copy; {{ date('Y') }} Copy Rigt.</span>
            <span class="text-slate-300">Managed by Nabil Adillah Supardy</span>
        </footer>

    </div>

    <script>
        lucide.createIcons();

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const main = document.getElementById('mainContent');

            sidebar.classList.toggle('sidebar-collapsed');

            if (sidebar.classList.contains('sidebar-collapsed')) {
                main.classList.replace('ml-72', 'ml-[88px]');
            } else {
                main.classList.replace('ml-[88px]', 'ml-72');
            }
        }

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#ffffff',
            color: '#1E293B',
            customClass: {
                popup: 'rounded-2xl shadow-xl border border-slate-50'
            }
        });

        @if(session('success'))
            Toast.fire({ icon: 'success', title: @json(session('success')) });
        @endif

        @if(session('error'))
            Toast.fire({ icon: 'error', title: @json(session('error')) });
        @endif

        function confirmLogout() {
            Swal.fire({
                title: 'Sign Out?',
                text: 'Are you sure you want to end your current session?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4F46E5',
                cancelButtonColor: '#94A3B8',
                confirmButtonText: 'Yes, Sign Out',
                customClass: {
                    popup: 'rounded-[1.5rem]',
                    confirmButton: 'rounded-xl font-bold px-6 py-3',
                    cancelButton: 'rounded-xl font-bold px-6 py-3'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }
    </script>
</body>
</html>