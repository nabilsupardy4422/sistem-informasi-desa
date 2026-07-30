<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login Admin - SI Desa Premium</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Poppins', 'sans-serif'],
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'fade-in-up': 'fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        fadeInUp: {
                            '0%': { opacity: 0, transform: 'translateY(20px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #FAFAFA;
            overflow: hidden; /* Mencegah scroll di halaman login */
        }

        /* Premium Input Styling */
        .input-neo {
            background: #ffffff;
            border: 2px solid #F1F5F9;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-neo:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15), 0 2px 10px rgba(0, 0, 0, 0.02);
            transform: translateY(-2px);
        }
        .input-icon {
            transition: color 0.3s ease;
        }
        .input-neo:focus + .input-icon {
            color: #3B82F6;
        }

        /* Animated Button */
        .btn-neo {
            background-size: 200% auto;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-neo:hover {
            background-position: right center;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -5px rgba(37, 99, 235, 0.4);
        }
        .btn-neo:active {
            transform: translateY(1px);
        }

        /* Staggered Animation Utilities */
        .stagger-1 { animation-delay: 100ms; opacity: 0; }
        .stagger-2 { animation-delay: 200ms; opacity: 0; }
        .stagger-3 { animation-delay: 300ms; opacity: 0; }
        .stagger-4 { animation-delay: 400ms; opacity: 0; }

        /* Custom Checkbox */
        .checkbox-neo {
            appearance: none;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #CBD5E1;
            border-radius: 0.375rem;
            background-color: white;
            transition: all 0.2s;
            cursor: pointer;
            position: relative;
        }
        .checkbox-neo:checked {
            background-color: #3B82F6;
            border-color: #3B82F6;
        }
        .checkbox-neo:checked::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 1px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
</head>
<body class="min-h-screen text-slate-800 antialiased selection:bg-blue-500 selection:text-white flex items-center justify-center">

    <div class="fixed inset-0 z-[-1] lg:hidden bg-gradient-to-br from-slate-50 to-slate-200">
        <div class="absolute top-[-10%] left-[-10%] w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-[20%] right-[-10%] w-72 h-72 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    </div>

    <div class="w-full max-w-[1400px] h-[100vh] lg:h-[90vh] lg:max-h-[900px] flex lg:rounded-[3rem] lg:overflow-hidden lg:shadow-2xl lg:shadow-slate-300/50 bg-white relative m-4">

        {{-- LEFT PANEL (BRANDING / DARK MESH) --}}
        <div class="hidden lg:flex w-[45%] relative overflow-hidden bg-[#0F172A] flex-col justify-between p-16">

            <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-600 rounded-full mix-blend-screen filter blur-[100px] opacity-70 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-cyan-500 rounded-full mix-blend-screen filter blur-[100px] opacity-70 animate-blob" style="animation-delay: 2s"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-600 rounded-full mix-blend-screen filter blur-[100px] opacity-70 animate-blob" style="animation-delay: 4s"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20 pointer-events-none"></div>

            <div class="relative z-10 animate-fade-in-up stagger-1">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center text-white shadow-lg group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-building-columns text-xl"></i>
                    </div>
                    <div>
                        <h2 class="font-display font-black text-2xl text-white tracking-tight leading-none">SI Desa</h2>
                        <span class="text-[10px] uppercase tracking-widest text-cyan-400 font-bold">Portal Utama</span>
                    </div>
                </a>
            </div>

            <div class="relative z-10 my-auto animate-fade-in-up stagger-2">
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 px-4 py-2 rounded-full mb-6 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] font-black text-white uppercase tracking-widest">Sistem Manajemen Terpadu</span>
                </div>

                <h1 class="text-5xl xl:text-6xl font-display font-black text-white leading-[1.1] mb-6 tracking-tight">
                    Kelola Desa <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">Lebih Cerdas.</span>
                </h1>

                <p class="text-slate-300 text-lg leading-relaxed max-w-md font-light">
                    Satu platform terintegrasi untuk mendigitalisasi layanan administrasi publik, transparansi keuangan, dan memajukan potensi UMKM lokal.
                </p>
            </div>
        </div>

        {{-- RIGHT PANEL (LOGIN FORM) --}}
        <div class="w-full lg:w-[55%] flex flex-col items-center justify-center p-8 sm:p-12 lg:p-24 relative overflow-y-auto">

            <div class="w-full max-w-md mx-auto">
                <div class="lg:hidden text-center mb-10 animate-fade-in-up stagger-1">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-500 text-white mb-4 shadow-xl shadow-blue-500/20">
                        <i class="fa-solid fa-building-columns text-2xl"></i>
                    </div>
                    <h1 class="text-3xl font-display font-black text-slate-900 tracking-tight">SI <span class="text-blue-600">Desa</span></h1>
                </div>

                <div class="text-center lg:text-left mb-10 animate-fade-in-up stagger-1">
                    <h2 class="text-3xl md:text-4xl font-display font-black text-slate-900 mb-3 tracking-tight">Selamat Datang 👋</h2>
                    <p class="text-slate-500 font-medium">Silakan masukkan kredensial Anda untuk masuk ke panel administrator.</p>
                </div>

                <div class="animate-fade-in-up stagger-2">
                    @if (session('status'))
                        <div class="mb-6 flex items-start gap-3 bg-emerald-50 border border-emerald-100 p-4 rounded-2xl">
                            <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 shrink-0"></i>
                            <p class="text-sm font-bold text-emerald-800">{{ session('status') }}</p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 flex items-start gap-3 bg-rose-50 border border-rose-100 p-4 rounded-2xl">
                            <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 shrink-0"></i>
                            <div class="text-sm font-bold text-rose-800">
                                <ul class="list-disc pl-4 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6 animate-fade-in-up stagger-3">
                    @csrf

                    <div>
                        <label for="email" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">
                            Alamat Email
                        </label>
                        <div class="relative flex items-center group">
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="admin@desa.com"
                                class="input-neo w-full pl-12 pr-5 py-4 rounded-2xl text-slate-800 outline-none placeholder:text-slate-400 placeholder:font-light font-semibold z-10 relative"
                            >
                            <div class="absolute left-4 z-20 pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-regular fa-envelope text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">
                            Password
                        </label>
                        <div class="relative flex items-center group">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="input-neo w-full pl-12 pr-5 py-4 rounded-2xl text-slate-800 outline-none placeholder:text-slate-400 placeholder:font-light font-semibold z-10 relative"
                            >
                            <div class="absolute left-4 z-20 pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                                <i class="fa-solid fa-lock text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2 pb-2">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input id="remember_me" type="checkbox" name="remember" class="checkbox-neo">
                            <span class="text-sm font-bold text-slate-500 group-hover:text-slate-800 transition-colors select-none">Ingat Sesi Saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn-neo w-full bg-gradient-to-r from-blue-600 via-cyan-500 to-blue-600 text-white py-4 rounded-2xl font-black text-base shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2 group">
                        Masuk ke Dashboard
                        <i class="fa-solid fa-arrow-right-to-bracket group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

                <div class="mt-10 text-center animate-fade-in-up stagger-4">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-700 transition-colors bg-slate-50 hover:bg-slate-100 px-5 py-2.5 rounded-full border border-slate-200">
                        <i class="fa-solid fa-arrow-left-long"></i> Kembali ke Website Publik
                    </a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>