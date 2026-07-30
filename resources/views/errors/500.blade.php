<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Kesalahan Sistem | SI Desa</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top right, rgba(239,68,68,0.15), transparent 30%),
                radial-gradient(circle at bottom left, rgba(244,63,94,0.12), transparent 35%),
                linear-gradient(135deg, #f8fafc, #fff1f2);
            overflow-x: hidden;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatY {
            0%,100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulseGlow {
            0%,100% {
                box-shadow: 0 0 0 rgba(239,68,68,0);
            }
            50% {
                box-shadow: 0 0 50px rgba(239,68,68,0.18);
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(200%);
            }
        }

        .animate-fade {
            animation: fadeUp 0.9s ease forwards;
        }

        .animate-float {
            animation: floatY 6s ease-in-out infinite;
        }

        .animate-glow {
            animation: pulseGlow 4s ease-in-out infinite;
        }

        .floating-orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(70px);
            opacity: 0.25;
        }

        .grid-shimmer {
            position: relative;
            overflow: hidden;
        }

        .grid-shimmer::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                120deg,
                transparent 30%,
                rgba(255,255,255,0.08),
                transparent 70%
            );
            animation: shimmer 8s linear infinite;
        }

        .btn-modern {
            transition: all 0.3s ease;
        }

        .btn-modern:hover {
            transform: translateY(-4px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-6 py-10">

<div class="max-w-6xl w-full animate-fade">

    <div class="bg-white/90 backdrop-blur-xl border border-white shadow-2xl rounded-[2.5rem] overflow-hidden animate-glow">

        <div class="grid lg:grid-cols-2 min-h-[700px]">

            <!-- LEFT -->
            <div class="relative overflow-hidden bg-gradient-to-br from-red-700 via-rose-600 to-slate-800 text-white p-12 lg:p-16 flex flex-col justify-center">

                <div class="absolute inset-0 opacity-10 grid-shimmer"
                    style="background-image: linear-gradient(white 1px, transparent 1px), linear-gradient(90deg, white 1px, transparent 1px); background-size: 30px 30px;">
                </div>

                <div class="floating-orb w-72 h-72 bg-red-300 top-10 left-10 animate-float"></div>
                <div class="floating-orb w-80 h-80 bg-rose-300 bottom-10 right-10 animate-float" style="animation-delay:2s;"></div>

                <div class="relative z-10">

                    <div class="inline-flex items-center px-5 py-2 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-sm font-semibold mb-8">
                        SI DESA DIGITAL PLATFORM
                    </div>

                    <div class="text-8xl lg:text-9xl font-black mb-8 opacity-90">
                        500
                    </div>

                    <h1 class="text-4xl lg:text-5xl font-black leading-tight mb-6 uppercase">
                        Kesalahan Sistem Internal
                    </h1>

                    <p class="text-red-100 text-lg leading-relaxed max-w-xl">
                        Sistem mengalami gangguan internal saat memproses permintaan Anda.
                        Permintaan tidak dapat diselesaikan untuk sementara waktu.
                    </p>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="p-10 lg:p-16 flex flex-col justify-center">

                <div class="w-28 h-28 rounded-[2rem] bg-red-100 flex items-center justify-center text-6xl mb-8 animate-float">
                    ⚠️
                </div>

                <h2 class="text-3xl lg:text-4xl font-black text-slate-800 mb-5">
                    Internal Server Error
                </h2>

                <p class="text-slate-500 text-lg leading-relaxed mb-10">
                    Terjadi gangguan pada server aplikasi SI Desa.
                    Silakan coba kembali dalam beberapa saat atau gunakan layanan publik lain.
                </p>

                <div class="space-y-4">

                    <button onclick="window.location.reload()"
                        class="btn-modern block w-full bg-red-600 hover:bg-red-700 text-white text-center py-4 rounded-2xl font-bold text-lg shadow-lg">
                        Coba Lagi
                    </button>

                    <a href="{{ route('home') }}"
                        class="btn-modern block w-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-center py-4 rounded-2xl font-semibold">
                        Kembali ke Beranda
                    </a>

                    <a href="{{ route('public.tracking.index') }}"
                        class="btn-modern block w-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-center py-4 rounded-2xl font-semibold">
                        Buka Tracking Publik
                    </a>

                    <a href="{{ route('login') }}"
                        class="btn-modern block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-4 rounded-2xl font-bold">
                        Login Administrator
                    </a>

                </div>

                <div class="mt-10 pt-8 border-t border-slate-200">

                    <h3 class="text-lg font-bold text-slate-800 mb-4">
                        Kemungkinan penyebab:
                    </h3>

                    <ul class="space-y-3 text-slate-500">
                        <li>• Gangguan server aplikasi</li>
                        <li>• Error proses backend</li>
                        <li>• Kegagalan koneksi database</li>
                        <li>• Sistem sedang maintenance</li>
                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>