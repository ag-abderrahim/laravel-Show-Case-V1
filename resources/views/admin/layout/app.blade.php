<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- AlertifyJS CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>

    {{-- Datatables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-zinc-100 text-zinc-900 antialiased">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-black text-white flex flex-col fixed inset-y-0 left-0 shadow-2xl z-50">

        <!-- Logo -->
        <div class="h-20 flex items-center px-8 border-b border-zinc-800">

            <h1 class="text-3xl font-black tracking-wide">
                LABO<span class="text-zinc-500">APP</span>
            </h1>

        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-5 py-8 space-y-3">

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl bg-white text-black font-semibold shadow-lg transition hover:scale-[1.02]">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 10l9-7 9 7v11a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V10z"/>
                </svg>

                Dashboard
            </a>

            <!-- Users -->
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl hover:bg-zinc-900 transition duration-200">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2m12 0H7m10-10a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>

                Users
            </a>

            <!-- Roles -->
            <a href="{{ route('roles.index') }}"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl hover:bg-zinc-900 transition duration-200">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0-6v2m0 16v2m8-10h2M2 12H4m12.364 6.364l1.414 1.414M4.222 4.222l1.414 1.414m0 12.728l-1.414 1.414m12.728-12.728l1.414-1.414"/>
                </svg>

                Roles
            </a>

            <!-- Permissions -->
            <a href="{{ route('permissions.index') }}"
               class="flex items-center gap-4 px-5 py-4 rounded-2xl hover:bg-zinc-900 transition duration-200">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>

                Permissions
            </a>

        </nav>

        <!-- User -->
        <div class="p-5 border-t border-zinc-800">

            <div class="bg-zinc-900 rounded-2xl p-4 flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <div class="w-11 h-11 rounded-full bg-white text-black flex items-center justify-center font-bold text-lg">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>

                    <div>
                        <p class="font-semibold text-sm">
                            {{ Auth::user()->name ?? 'Admin' }}
                        </p>

                        <p class="text-xs text-zinc-400">
                            Administrator
                        </p>
                    </div>

                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="text-xs bg-white text-black px-3 py-2 rounded-xl hover:bg-zinc-200 transition">
                        Logout
                    </button>
                </form>

            </div>

        </div>

    </aside>

    <!-- MAIN -->
    <main class="flex-1 ml-72">

        <!-- TOPBAR -->
        <header class="h-20 bg-white border-b border-zinc-200 flex items-center justify-between px-10 sticky top-0 z-40">

            <div>
                <h2 class="text-2xl font-bold">
                    @yield('title', 'Dashboard')
                </h2>

                <p class="text-sm text-zinc-500 mt-1">
                    Welcome back 👋
                </p>
            </div>

            <div class="flex items-center gap-4">

                <button class="bg-black text-white px-5 py-2.5 rounded-2xl font-medium hover:opacity-90 transition">
                    Admin Panel
                </button>

            </div>

        </header>

        <!-- CONTENT -->
        <section class="p-10">

            @yield('content')

        </section>

    </main>

</div>

    <!-- AlertifyJS JS -->
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>
        @if(session('success'))
            alertify.set('notifier','position', 'bottom-right');
            alertify.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            alertify.set('notifier','position', 'bottom-right');
            alertify.error("{{ session('error') }}");
        @endif

        @if(session('info'))
            alertify.set('notifier','position', 'bottom-right');
            alertify.message("{{ session('info') }}");
        @endif

        @if(session('warning'))
            alertify.set('notifier','position', 'bottom-right');
            alertify.warning("{{ session('warning') }}");
        @endif
    </script>

    <script>
        function showAlert(type, message) {

            alertify.set('notifier','position', 'bottom-right');

            if (type === 'success') alertify.success(message);
            else if (type === 'error') alertify.error(message);
            else if (type === 'warning') alertify.warning(message);
            else alertify.message(message);
        }
    </script>

    {{-- DataTables --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#aTable').DataTable({
                pageLength: 5,
                lengthChange: false,
                ordering: true,
                info: false,
                language: {
                    search: "",
                    searchPlaceholder: "Search permissions..."
                }
            });
        });
    </script>
</body>
</html>
