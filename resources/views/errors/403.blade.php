<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top right, rgba(59,130,246,0.12), transparent 30%),
                radial-gradient(circle at bottom left, rgba(14,165,233,0.10), transparent 35%),
                linear-gradient(135deg, #f8fafc, #eef2ff);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-6">

    <div class="max-w-5xl w-full">

        <div class="bg-white/90 backdrop-blur-xl border border-white shadow-2xl rounded-[2.5rem] overflow-hidden">

            <div class="grid lg:grid-cols-2 min-h-[650px]">

                <!-- LEFT -->
                <div class="relative overflow-hidden bg-gradient-to-br from-amber-600 via-orange-500 to-red-600 text-white p-12 lg:p-16 flex flex-col justify-center">

                    <div class="absolute inset-0 opacity-10"
                        style="background-image: linear-gradient(white 1px, transparent 1px), linear-gradient(90deg, white 1px, transparent 1px); background-size: 30px 30px;">
                    </div>

                    <div class="relative z-10">

                        <div class="inline-flex items-center px-5 py-2 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-sm font-semibold mb-8">
                            WEBSITE RESMI PEMERINTAH DESA
                        </div>

                        <div class="text-8xl lg:text-9xl font-black mb-8 opacity-90">
                            403
                        </div>

                        <h1 class="text-4xl lg:text-5xl font-black leading-tight mb-6 uppercase">
                            Akses Ditolak
                        </h1>

                        <p class="text-orange-100 text-lg leading-relaxed max-w-xl">
                            Anda tidak memiliki izin untuk mengakses halaman ini. Sistem membatasi akses untuk melindungi data dan area administratif.
                        </p>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="p-10 lg:p-16 flex flex-col justify-center">

                    <div class="w-28 h-28 rounded-[2rem] bg-orange-100 flex items-center justify-center text-6xl mb-8">
                        🔒
                    </div>

                    <h2 class="text-3xl lg:text-4xl font-black text-slate-800 mb-5">
                        Maaf, akses Anda dibatasi
                    </h2>

                    <p class="text-slate-500 text-lg leading-relaxed mb-10">
                        Halaman ini hanya dapat diakses oleh pengguna yang memiliki hak akses tertentu, seperti administrator sistem desa.
                    </p>

                    <div class="space-y-4">

                        <a href="/"
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-4 rounded-2xl font-bold text-lg shadow-lg transition">
                            Kembali ke Beranda
                        </a>

                        <a href="/login"
                           class="block w-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-center py-4 rounded-2xl font-semibold transition">
                            Login Administrator
                        </a>

                        <a href="/tracking"
                           class="block w-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-center py-4 rounded-2xl font-semibold transition">
                            Buka Tracking Publik
                        </a>

                    </div>

                    <div class="mt-10 pt-8 border-t border-slate-200">

                        <h3 class="text-lg font-bold text-slate-800 mb-4">
                            Kemungkinan penyebab:
                        </h3>

                        <ul class="space-y-3 text-slate-500">
                            <li>• Anda belum login sebagai administrator</li>
                            <li>• Hak akses akun Anda terbatas</li>
                            <li>• Halaman ini khusus area administratif</li>
                            <li>• Sesi login Anda telah berubah atau dibatasi</li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>