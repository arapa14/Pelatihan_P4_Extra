<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard') • Kantor Papoy</title>
    @vite('resources/css/app.css')
    {{-- Toastr CSS --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    {{-- Toastr JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        /* shared glass style */
        .glass {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02));
            backdrop-filter: blur(6px) saturate(120%);
        }

        .overlay-fade {
            transition: opacity 0.28s ease;
        }
    </style>
    @stack('head') {{-- tambahan head jika halaman butuh --}}
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-700 text-slate-100 flex">

    {{-- Sidebar (component/partial) --}}
    @include('components.sidebar', ['active' => $active ?? null])

    {{-- Overlay mobile --}}
    <div id="overlay" class="fixed inset-0 bg-black/50 opacity-0 hidden overlay-fade md:hidden z-30"></div>

    {{-- Main content area --}}
    <div class="flex-1 flex flex-col min-h-screen md-64">

        {{-- Header --}}
        @include('components.header', ['title' => $title ?? 'Dashboard'])

        {{-- Main --}}
        <main class="flex-1 p-4 md:p-8 overflow-y-auto">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('components.footer')
    </div>

    {{-- Script (sidebar toggle + small helpers) --}}
    <script>
        (function() {
            const menuBtn = document.getElementById("menuBtn");
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            if (menuBtn) {
                menuBtn.addEventListener("click", () => {
                    sidebar.classList.remove("-translate-x-full");
                    overlay.classList.remove("hidden");
                    // fade in
                    requestAnimationFrame(() => {
                        overlay.classList.remove("opacity-0");
                        overlay.classList.add("opacity-100");
                    });
                });
            }
            if (overlay) {
                overlay.addEventListener("click", () => {
                    sidebar.classList.add("-translate-x-full");
                    overlay.classList.remove("opacity-100");
                    overlay.classList.add("opacity-0");
                    setTimeout(() => overlay.classList.add("hidden"), 300);
                });
            }
            // helper to set active menu from server-side via data-active attribute (optional)
        })();

        @if (session('success'))
            toastr.success("{{ session('success') }}", "Sukses");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}", "Error");
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}", "Perhatian");
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}", "Info");
        @endif
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: "Data pegawai akan dihapus permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e3342f',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    </script>

    @stack('scripts') {{-- tambahan script jika halaman butuh --}}
</body>

</html>
