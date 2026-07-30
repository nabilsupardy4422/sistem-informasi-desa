<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#0F172A">
    <meta name="description" content="Sistem Informasi Desa Modern terintegrasi untuk transparansi dan kemudahan layanan publik.">
    <meta name="keywords" content="Smart Village, Desa Digital, Sistem Informasi Desa, E-Government">

    <meta property="og:title" content="@yield('title', 'SI Desa — Smart Village Ecosystem')">
    <meta property="og:description" content="Sistem Informasi Desa Modern terintegrasi.">
    <meta property="og:type" content="website">

    <title>@yield('title', 'SI Desa — Smart Village Ecosystem')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            50: '#f0f4f8',
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        },
                        cyan: {
                            glow: '#22d3ee',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-glow': 'pulseGlow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'fade-up': 'fadeUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        pulseGlow: {
                            '0%, 100%': { opacity: 1, boxShadow: '0 0 20px rgba(34, 211, 238, 0.4)' },
                            '50%': { opacity: .5, boxShadow: '0 0 40px rgba(34, 211, 238, 0.8)' },
                        },
                        fadeUp: {
                            '0%': { opacity: 0, transform: 'translateY(30px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Custom Scrollbar Elegant */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        body {
            background-color: #FAFAFA;
            color: #0f172a;
            overflow-x: hidden;
        }

        /* Loading Screen Transition */
        #page-transition {
            transition: opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1), visibility 0.6s;
        }

        /* Mesh / Blob Background */
        .ambient-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            background: #FAFAFA;
            overflow: hidden;
        }
        .ambient-blob {
            position: absolute;
            filter: blur(100px);
            opacity: 0.4;
            border-radius: 50%;
            animation: float 10s ease-in-out infinite alternate;
        }

        /* Glassmorphism Utilities */
        .glass {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
        }

        .glass-dark {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Floating Navbar */
        .nav-dock {
            transition: all 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .nav-scrolled {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.85) !important;
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08);
        }

        /* Premium Nav Links */
        .nav-link {
            position: relative;
            font-size: 0.875rem;
            font-weight: 500;
            color: #475569;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0%;
            height: 2px;
            background: #2563eb;
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        .nav-link:hover { color: #0f172a; }
        .nav-link:hover::after, .nav-link.active::after { width: 80%; }
        .nav-link.active { color: #0f172a; font-weight: 600; }

        /* Smooth Reveal Animation */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Gradient Text Utility */
        .text-gradient {
            background: linear-gradient(to right, #2563eb, #22d3ee);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        #scroll-progress {
            position: fixed;
            top: 0; left: 0; width: 0%; height: 3px;
            background: linear-gradient(90deg, #2563eb, #22d3ee);
            z-index: 9999;
        }
    </style>

    @stack('styles')
</head>

<body class="antialiased selection:bg-blue-600 selection:text-white flex flex-col min-h-screen">

    <div id="page-transition" class="fixed inset-0 z-[9999] bg-white flex flex-col items-center justify-center">
        <div class="relative w-16 h-16 flex items-center justify-center">
            <div class="absolute inset-0 rounded-full border-t-2 border-blue-600 animate-spin"></div>
            <div class="absolute inset-2 rounded-full border-r-2 border-cyan-400 animate-spin" style="animation-direction: reverse; animation-duration: 0.8s;"></div>
            <i class="fa-solid fa-leaf text-blue-600 text-xl animate-pulse"></i>
        </div>
        <p class="mt-4 font-display font-medium text-slate-400 tracking-widest text-xs uppercase animate-pulse">Memuat Sistem</p>
    </div>

    <div class="ambient-bg">
        <div class="ambient-blob bg-blue-300 w-[500px] h-[500px] top-[-10%] left-[-10%]"></div>
        <div class="ambient-blob bg-cyan-200 w-[400px] h-[400px] top-[40%] right-[-5%]" style="animation-delay: 2s;"></div>
        <div class="ambient-blob bg-indigo-100 w-[600px] h-[600px] bottom-[-20%] left-[20%]" style="animation-delay: 4s;"></div>
    </div>

    <div id="scroll-progress"></div>

    <header class="fixed top-6 inset-x-0 z-50 flex justify-center px-4 pointer-events-none">
        <nav id="navbar" class="pointer-events-auto nav-dock glass rounded-full px-4 py-2.5 w-full max-w-5xl flex items-center justify-between">

            <a href="{{ url('/') }}" class="flex items-center gap-3 group pl-2">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300 group-hover:scale-105">
                    <i class="fa-solid fa-building-columns text-sm"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-display font-bold text-slate-900 leading-none tracking-tight">SI <span class="text-blue-600">Desa</span></span>
                    <span class="text-[9px] uppercase tracking-[0.2em] text-slate-500 font-semibold mt-0.5">Smart Village</span>
                </div>
            </a>

            <div class="hidden lg:flex items-center gap-2">
                <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                <a href="{{ url('/berita') }}" class="nav-link {{ request()->is('berita*') ? 'active' : '' }}">Berita</a>

                <div class="relative group">
                    <button class="nav-link flex items-center gap-1 {{ request()->is('penduduk*') || request()->is('apbdes*') || request()->is('umkm*') ? 'active' : '' }}">
                        Infografis <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute top-full left-1/2 -translate-x-1/2 pt-4 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-3 group-hover:translate-y-0 w-48 z-50">
                        <div class="glass rounded-2xl p-2 flex flex-col gap-1 shadow-xl">
                            <a href="{{ url('/penduduk') }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-blue-600 hover:bg-blue-50/50 rounded-xl transition-all flex items-center gap-3">
                                <i class="fa-solid fa-users text-blue-500 w-4"></i> Penduduk
                            </a>
                            <a href="{{ url('/apbdes') }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-blue-600 hover:bg-blue-50/50 rounded-xl transition-all flex items-center gap-3">
                                <i class="fa-solid fa-chart-pie text-cyan-500 w-4"></i> APBDes
                            </a>
                            <a href="{{ url('/umkm') }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-blue-600 hover:bg-blue-50/50 rounded-xl transition-all flex items-center gap-3">
                                <i class="fa-solid fa-store text-indigo-500 w-4"></i> UMKM
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/layanan') }}" class="nav-link {{ request()->is('layanan*') ? 'active' : '' }}">Layanan</a>
                <a href="{{ url('/pengaduan') }}" class="nav-link {{ request()->is('pengaduan*') ? 'active' : '' }}">Pengaduan</a>
                <a href="{{ url('/tracking') }}" class="nav-link {{ request()->is('tracking*') ? 'active' : '' }}">Tracking</a>
            </div>

            <div class="flex items-center gap-3 pr-1">
                @auth
                    <a href="{{ url('/admin/dashboard') }}" class="hidden lg:flex items-center gap-2 bg-navy-900 text-white px-5 py-2.5 rounded-full font-medium text-sm transition-all hover:bg-blue-600 hover:shadow-lg hover:shadow-blue-500/25">
                        <i class="fa-solid fa-chart-pie text-xs"></i> Dashboard
                    </a>
                @else
                    <a href="{{ url('/login') }}" class="hidden lg:flex items-center gap-2 bg-navy-900 text-white px-5 py-2.5 rounded-full font-medium text-sm transition-all hover:bg-blue-600 hover:shadow-lg hover:shadow-blue-500/25">
                        <i class="fa-solid fa-lock text-xs"></i> Login Admin
                    </a>
                @endauth

                <button onclick="toggleMobileMenu()" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-full bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
            </div>
        </nav>
    </header>

    <div id="mobileMenu" class="fixed inset-0 z-[40] bg-white/80 backdrop-blur-2xl opacity-0 invisible transition-all duration-500 flex flex-col justify-center px-8">
        <button onclick="toggleMobileMenu()" class="absolute top-8 right-8 w-12 h-12 flex items-center justify-center rounded-full bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="flex flex-col gap-5 text-center font-display">
            <h3 class="text-xs uppercase tracking-[0.3em] text-slate-400 mb-2 font-bold">Navigasi Global</h3>
            <a href="{{ url('/') }}" class="text-3xl font-bold text-slate-900 hover:text-blue-600 transition-colors">Beranda</a>
            <a href="{{ url('/berita') }}" class="text-3xl font-bold text-slate-900 hover:text-blue-600 transition-colors">Berita Desa</a>

            <div class="py-4 my-2 border-y border-slate-200/50 flex flex-col gap-4 bg-slate-50/30 rounded-3xl">
                <h3 class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-bold">Infografis</h3>
                <a href="{{ url('/penduduk') }}" class="text-2xl font-semibold text-slate-700 hover:text-blue-600 transition-colors">Penduduk</a>
                <a href="{{ url('/apbdes') }}" class="text-2xl font-semibold text-slate-700 hover:text-blue-600 transition-colors">APBDes</a>
                <a href="{{ url('/umkm') }}" class="text-2xl font-semibold text-slate-700 hover:text-blue-600 transition-colors">UMKM</a>
            </div>

            <a href="{{ url('/layanan') }}" class="text-3xl font-bold text-slate-900 hover:text-blue-600 transition-colors">E-Layanan</a>
            <a href="{{ url('/pengaduan') }}" class="text-3xl font-bold text-slate-900 hover:text-blue-600 transition-colors">Pengaduan</a>
            <a href="{{ url('/tracking') }}" class="text-3xl font-bold text-slate-900 hover:text-blue-600 transition-colors">Lacak Berkas</a>

            <div class="mt-6">
                @auth
                    <a href="{{ url('/admin/dashboard') }}" class="inline-flex items-center justify-center gap-2 w-full bg-blue-600 text-white py-4 rounded-2xl font-bold text-lg shadow-xl shadow-blue-500/20">
                        Masuk Dashboard
                    </a>
                @else
                    <a href="{{ url('/login') }}" class="inline-flex items-center justify-center gap-2 w-full bg-navy-900 text-white py-4 rounded-2xl font-bold text-lg shadow-xl">
                        <i class="fa-solid fa-user-shield"></i> Portal Admin
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <main class="flex-grow {{ request()->is('/') ? '' : 'pt-32' }} pb-20 relative z-10">
        @yield('content')
    </main>

    <footer class="relative bg-navy-950 pt-20 pb-10 overflow-hidden text-slate-300 border-t border-slate-800 z-10 mt-auto">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-2xl h-1 bg-gradient-to-r from-transparent via-cyan-500 to-transparent opacity-50"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[300px] bg-cyan-500/10 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="container mx-auto px-6 lg:px-8 relative z-10 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">

                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-white/10 border border-white/20 rounded-xl flex items-center justify-center text-white backdrop-blur-sm">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-display font-bold text-white text-xl leading-none">SI Desa</span>
                            <span class="text-[10px] uppercase tracking-[0.2em] text-cyan-400 font-semibold mt-1">Smart Village</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed mb-6 font-light">
                        Membangun ekosistem digital pemerintahan desa yang transparan, responsif, dan mudah diakses oleh seluruh lapisan masyarakat.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-display font-bold mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-400"></span> Akses Cepat
                    </h4>
                    <ul class="space-y-4 text-sm font-light">
                        <li><a href="{{ url('/') }}" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Beranda</a></li>
                        <li><a href="{{ url('/berita') }}" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Portal Berita</a></li>
                        <li><a href="{{ url('/apbdes') }}" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Transparansi APBDes</a></li>
                        <li><a href="{{ url('/umkm') }}" class="hover:text-cyan-400 transition-colors flex items-center gap-2"><i class="fa-solid fa-angle-right text-[10px]"></i> Katalog UMKM</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-display font-bold mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> E-Layanan
                    </h4>
                    <ul class="space-y-4 text-sm font-light">
                        <li><a href="{{ url('/layanan') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class="fa-regular fa-file-lines text-slate-500"></i> Pengajuan Surat</a></li>
                        <li><a href="{{ url('/tracking') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class="fa-solid fa-magnifying-glass text-slate-500"></i> Lacak Permohonan</a></li>
                        <li><a href="{{ url('/pengaduan') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class="fa-regular fa-comment-dots text-slate-500"></i> Lapor Kendala</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-display font-bold mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span> Hubungi Kami
                    </h4>
                    <ul class="space-y-4 text-sm font-light">
                        <li class="flex items-start gap-3">
                            <i class="fa-solid fa-location-dot mt-1 text-slate-500"></i>
                            <span>Kantor Kepala Desa<br>Jl. Pemerintahan No. 1, Kec. Digital</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-solid fa-phone text-slate-500"></i>
                            <span>(021) 1234-5678</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-regular fa-envelope text-slate-500"></i>
                            <span>pemdes@smartvillage.id</span>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-slate-800/60 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-500 font-light">
                    &copy; {{ date('Y') }} SI Desa. All rights reserved.
                </p>
                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <span>Copy right by</span> <i class="fa-solid fa-heart text-red-500/70 text-[10px]"></i> <span>Nabil Adillah Supardy.</span>
                </div>
            </div>
        </div>
    </footer>

    <button id="backToTop" class="fixed bottom-8 right-8 z-50 w-12 h-12 rounded-full bg-navy-900 text-white shadow-xl opacity-0 invisible transform translate-y-4 transition-all duration-300 hover:bg-blue-600 hover:-translate-y-1">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <script>
        // PAGE TRANSITION / LOADER
        window.addEventListener('load', () => {
            const loader = document.getElementById('page-transition');
            setTimeout(() => {
                loader.style.opacity = '0';
                loader.style.visibility = 'hidden';
            }, 300); // Slight delay for smooth effect
        });

        // NAVBAR SCROLL & PROGRESS BAR
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            const progress = document.getElementById('scroll-progress');
            const backToTop = document.getElementById('backToTop');

            // Progress Bar
            const scrollPercent = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            progress.style.width = scrollPercent + '%';

            // Navbar
            if (window.scrollY > 20) {
                nav.classList.add('nav-scrolled');
                nav.classList.remove('px-4', 'py-2.5');
                nav.classList.add('px-6', 'py-3');
            } else {
                nav.classList.remove('nav-scrolled');
                nav.classList.add('px-4', 'py-2.5');
                nav.classList.remove('px-6', 'py-3');
            }

            // Back to Top
            if (window.scrollY > 400) {
                backToTop.classList.remove('opacity-0', 'invisible', 'translate-y-4');
            } else {
                backToTop.classList.add('opacity-0', 'invisible', 'translate-y-4');
            }
        });

        // BACK TO TOP ACTION
        document.getElementById('backToTop').addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // MOBILE MENU TOGGLE
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if(menu.classList.contains('opacity-0')) {
                menu.classList.remove('opacity-0', 'invisible');
            } else {
                menu.classList.add('opacity-0', 'invisible');
            }
        }

        // INTERSECTION OBSERVER FOR REVEAL ANIMATIONS
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target); // Reveal only once
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => {
            observer.observe(el);
        });

        // SWEETALERT2 MODERN CONFIG
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: '#ffffff',
            color: '#0f172a',
            customClass: {
                popup: 'rounded-2xl border border-slate-100 shadow-xl'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: @json(session('success'))
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: @json(session('error'))
            });
        @endif

        // Loading function helper for forms/ajax
        function showLoading(title = 'Memproses data...') {
            Swal.fire({
                title: title,
                allowOutsideClick: false,
                showConfirmButton: false,
                background: '#ffffff',
                customClass: {
                    title: 'font-display font-bold text-slate-800 text-lg',
                    popup: 'rounded-[2rem] p-8'
                },
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>