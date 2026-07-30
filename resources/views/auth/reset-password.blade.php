<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Setel Ulang Password - SI Desa Premium</title>

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
            overflow: hidden;
        }

        /* Premium Input Styling */
        .input-neo {
            background: #ffffff;
            border: 2px solid #F1F5F9;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-neo:focus {
            border-color: #0D9488; /* Teal-600 */
            box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.15), 0 2px 10px rgba(0, 0, 0, 0.02);
            transform: translateY(-2px);
        }
        .input-icon {
            transition: color 0.3s ease;
        }
        .input-neo:focus + .input-icon {
            color: #0D9488;
        }

        /* Animated Button */
        .btn-neo {
            background-size: 200% auto;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-neo:hover {
            background-position: right center;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -5px rgba(13, 148, 136, 0.4);
        }
        .btn-neo:active {
            transform: translateY(1px);
        }

        /* Staggered Animation Utilities */
        .stagger-1 { animation-delay: 100ms; opacity: 0; }
        .stagger-2 { animation-delay: 200ms; opacity: 0; }
        .stagger-3 { animation-delay: 300ms; opacity: 0; }
        .stagger-4 { animation-delay: 400ms; opacity: 0; }
    </style>
</head>
<body class="min-h-screen text-slate-800 antialiased selection:bg-teal-500 selection:text-white flex items-center justify-center">

    <div class="fixed inset-0 z-[-1] lg:hidden bg-gradient-to-br from-slate-50 to-slate-200">
        <div class="absolute top-[-10%] left-[-10%] w-72 h-72 bg-teal-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-[20%] right-[-10%] w-72 h-72 bg-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    </div>

    <div class="w-full max-w-[1400px] h-[100vh] lg:h-[90vh] lg:max-h-[900px] flex lg:rounded-[3rem] lg:overflow-hidden lg:shadow-2xl lg:shadow-slate-300/50 bg-white relative m-4">

        {{-- LEFT PANEL (BRANDING / DARK MESH) --}}
        <div class="hidden lg:flex w-[45%] relative overflow-hidden bg-[#0F172A] flex-col justify-between p-16">

            <div class="absolute top-0 -left-4 w-72 h-72 bg-teal-600 rounded-full mix-blend-screen filter blur-[100px] opacity-60 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-cyan-500 rounded-full mix-blend-screen filter blur-[100px] opacity-60 animate-blob" style="animation-delay: 2s"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-blue-600 rounded-full mix-blend-screen filter blur-[100px] opacity-40 animate-blob" style="animation-delay: 4s"></div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20 pointer-events-none"></div>

            <div class="relative z-10 animate-fade-in-up stagger-1">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-400 rounded-2xl flex items-center justify-center text-white shadow-lg group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-building-columns text-xl"></i>
                    </div>
                    <div>
                        <h2 class="font-display font-black text-2xl text-white tracking-tight leading-none">SI Desa</h2>
                        <span class="text-[10px] uppercase tracking-widest text-teal-400 font-bold">Portal Utama</span>
                    </div>
                </a>
            </div>

            <div class="relative z-10 my-auto animate-fade-in-up stagger-2">
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 px-4 py-2 rounded-full mb-6 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                    <span class="text-[10px] font-black text-white uppercase tracking-widest">Pembaruan Kredensial</span>
                </div>

                <h1 class="text-5xl xl:text-6xl font-display font-black text-white leading-[1.1] mb-6 tracking-tight">
                    Setel Ulang <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-300 via-cyan-400 to-blue-400">Password Anda.</span>
                </h1>

                <p class="text-slate-300 text-lg leading-relaxed max-w-md font-light">
                    Buat password baru yang kuat untuk memulihkan akses administrator ke dashboard sistem informasi desa secara aman.
                </p>
            </div>

            <div class="relative z-10 animate-fade-in-up stagger-3 flex items-center gap-4 border-t border-white/10 pt-8">
                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white backdrop-blur-md">
                    <i class="fa-solid fa-key text-sm"></i>
                </div>
                <div class="text-sm text-slate-400 font-medium leading-tight">
                    Gunakan kombinasi <br><span class="text-white font-bold">Huruf, Angka, dan Simbol</span>
                </div>
            </div>
        </div>

        {{-- RIGHT PANEL (RESET PASSWORD FORM) --}}
        <div class="w-full lg:w-[55%] flex flex-col items-center justify-center p-8 sm:p-12 lg:p-24 relative overflow-y-auto">

            <div class="w-full max-w-md mx-auto">
                <div class="lg:hidden text-center mb-10 animate-fade-in-up stagger-1">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-500 text-white mb-4 shadow-xl shadow-teal-500/20">
                        <i class="fa-solid fa-building-columns text-2xl"></i>
                    </div>
                    <h1 class="text-3xl font-display font-black text-slate-900 tracking-tight">SI <span class="text-teal-600">Desa</span></h1>
                </div>

                <div class="text-center lg:text-left mb-10 animate-fade-in-up stagger-1">
                    <h2 class="text-3xl md:text-4xl font-display font-black text-slate-900 mb-3 tracking-tight flex items-center justify-center lg:justify-start gap-3">
                        <i class="fa-solid fa-unlock-keyhole text-teal-500"></i> Password Baru
                    </h2>
                    <p class="text-slate-500 font-medium leading-relaxed">
                        Silakan atur password baru Anda untuk melanjutkan ke sistem. Pastikan untuk mengingatnya dengan baik.
                    </p>
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

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6 animate-fade-in-up stagger-3">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label for="email" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">
                            Email Administrator
                        </label>
                        <div class="relative flex items-center group">
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email', $request->email) }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="admin@desa.com"
                                class="input-neo w-full pl-12 pr-5 py-4 rounded-2xl text-slate-800 outline-none placeholder:text-slate-400 placeholder:font-light font-semibold z-10 relative"
                            >
                            <div class="absolute left-4 z-20 pointer-events-none text-slate-400 group-focus-within:text-teal-500 transition-colors">
                                <i class="fa-regular fa-envelope text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">
                            Password Baru
                        </label>
                        <div class="relative flex items-center group">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="input-neo w-full pl-12 pr-5 py-4 rounded-2xl text-slate-800 outline-none placeholder:text-slate-400 placeholder:font-light font-semibold z-10 relative"
                            >
                            <div class="absolute left-4 z-20 pointer-events-none text-slate-400 group-focus-within:text-teal-500 transition-colors">
                                <i class="fa-solid fa-lock text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">
                            Ulangi Password Baru
                        </label>
                        <div class="relative flex items-center group">
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="input-neo w-full pl-12 pr-5 py-4 rounded-2xl text-slate-800 outline-none placeholder:text-slate-400 placeholder:font-light font-semibold z-10 relative"
                            >
                            <div class="absolute left-4 z-20 pointer-events-none text-slate-400 group-focus-within:text-teal-500 transition-colors">
                                <i class="fa-solid fa-circle-check text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-neo w-full bg-gradient-to-r from-teal-600 via-cyan-500 to-teal-600 text-white py-4 rounded-2xl font-black text-base shadow-lg shadow-teal-500/30 flex items-center justify-center gap-2 group mt-2">
                        Simpan Password Baru
                        <i class="fa-solid fa-floppy-disk group-hover:scale-110 transition-transform"></i>
                    </button>
                </form>

                <div class="mt-10 pt-6 border-t border-slate-100 text-center animate-fade-in-up stagger-4">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-700 transition-colors bg-slate-50 hover:bg-slate-100 px-5 py-2.5 rounded-full border border-slate-200">
                        <i class="fa-solid fa-arrow-left-long"></i> Batal & Kembali ke Login
                    </a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>