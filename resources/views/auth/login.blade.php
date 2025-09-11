@php
    $appName = DB::table('settings')->where('key', 'app_name')->value('value');
    $appLogo = DB::table('settings')->where('key', 'app_logo')->value('value');
@endphp

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login • {{ $appName }}</title>
    <meta name="description" content="Halaman login modern menggunakan Tailwind CSS" />
    @vite('resources/css/app.css')
    <style>
        /* Small utilities for subtle glass effect */
        .glass {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02));
            backdrop-filter: blur(6px) saturate(120%);
        }
    </style>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 text-slate-100 flex items-center justify-center">
    @php
        $appName = DB::table('settings')->where('key', 'app_name')->value('value');
        $appLogo = DB::table('settings')->where('key', 'app_logo')->value('value');
    @endphp

    <main class="w-full max-w-6xl mx-auto p-6 lg:p-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">

            <!-- Illustration / Hero -->
            <section class="hidden lg:flex flex-col items-start gap-6 p-8 rounded-2xl glass shadow-2xl">
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset($appLogo) }}" alt="Logo" class="w-12 h-12 rounded-lg object-cover">
                        <div>
                            <h1 class="text-2xl font-semibold">Selamat Datang di {{ $appName }}</h1>
                            <p class="text-sm text-slate-300">Masuk untuk melanjutkan ke dashboard dan manajemen
                                pegawai.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-[linear-gradient(135deg,rgba(255,255,255,0.03),transparent)] rounded-xl p-6 w-full">
                    <!-- Simple SVG illustration -->
                    <svg viewBox="0 0 800 600" class="w-full h-56">
                        <defs>
                            <linearGradient id="g1" x1="0" x2="1">
                                <stop offset="0%" stop-color="#06b6d4" stop-opacity="0.9" />
                                <stop offset="100%" stop-color="#3b82f6" stop-opacity="0.9" />
                            </linearGradient>
                        </defs>
                        <rect width="100%" height="100%" rx="20" fill="url(#g1)" opacity="0.12"></rect>
                        <g transform="translate(80,40)">
                            <rect x="10" y="40" width="260" height="40" rx="8" fill="#fff" opacity="0.06"></rect>
                            <rect x="10" y="100" width="200" height="120" rx="10" fill="#fff" opacity="0.04"></rect>
                            <circle cx="200" cy="170" r="30" fill="#fff" opacity="0.06"></circle>
                            <rect x="300" y="30" width="180" height="180" rx="12" fill="#fff" opacity="0.03"></rect>
                        </g>
                    </svg>
                </div>

                <p class="text-sm text-slate-300">Keamanan data adalah prioritas kami. Pastikan Anda tidak membagikan
                    kredensial akun kepada pihak lain.</p>

            </section>

            <!-- Form Card -->
            <section class="relative bg-white/5 rounded-3xl p-8 lg:p-12 glass shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset($appLogo) }}" alt="Logo" class="w-12 h-12 rounded-lg object-cover">
                        <div>
                            <h1 class="text-2xl font-semibold">Selamat Datang di {{ $appName }}</h1>
                            <p class="text-sm text-slate-300">Masuk untuk melanjutkan ke dashboard dan manajemen
                                pegawai.</p>
                        </div>
                    </div>
                    <!-- <a href="#" class="text-sm text-slate-300 hover:text-white">Bantuan?</a> -->
                </div>

                <form id="loginForm" class="space-y-5" method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-200 mb-2">Email</label>
                        <input id="email" name="email" type="email" required placeholder="you@example.com"
                            class="w-full px-4 py-3 bg-transparent border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent placeholder:text-slate-400" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-200 mb-2">Kata Sandi</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required minlength="6"
                                placeholder="Masukkan kata sandi"
                                class="w-full px-4 py-3 bg-transparent border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent placeholder:text-slate-400 pr-12" />
                            <button type="button" aria-label="Tampilkan kata sandi" id="togglePwd"
                                class="absolute right-2 top-1/2 -translate-y-1/2 px-3 py-2 rounded-lg text-slate-300 hover:text-white focus:outline-none">
                                <!-- Eye icon -->
                                <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M3 3l18 18"></path>
                                    <path d="M10.47 10.47a3 3 0 0 0 4.06 4.06"></path>
                                    <path d="M9.5 5.5C7 6.7 4.7 8.7 3 12c2.5 4 7 7 9 7 1.1 0 2.2-.4 3.2-1"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm text-slate-300">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox"
                                class="h-4 w-4 rounded border-slate-600 bg-transparent focus:ring-2 focus:ring-primary" />
                            <span>Ingat saya</span>
                        </label>
                        <a href="#" class="hover:text-white">Lupa kata sandi?</a>
                    </div>

                    <div>
                        <button id="submitBtn"
                            class="w-full py-3 rounded-xl bg-gradient-to-r from-primary to-accent text-white font-semibold shadow-md hover:scale-[1.01] active:scale-100 transition-transform">
                            Masuk
                        </button>
                    </div>

                </form>

                <footer class="mt-6 text-xs text-slate-500">Dengan masuk, Anda menyetujui <a href="#"
                        class="underline">ketentuan layanan</a> dan <a href="#" class="underline">kebijakan privasi</a>.
                </footer>

            </section>
        </div>
    </main>

    <script>
        // Toggle password visibility
        const toggle = document.getElementById('togglePwd');
        const pwd = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        toggle.addEventListener('click', () => {
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
                toggle.setAttribute('aria-pressed', 'true');
            } else {
                pwd.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
                toggle.setAttribute('aria-pressed', 'false');
            }
        });
    </script>
</body>

</html>