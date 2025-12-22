<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') - Auto-École</title>

    <!-- Preconnect pour optimisation -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.tailwindcss.com">

    <!-- Google Fonts - Figtree (optimisé) -->
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fef6ee',
                            100: '#fde9d3',
                            200: '#fbcfa5',
                            300: '#f8af6d',
                            400: '#f58332',
                            500: '#f2650d',
                            600: '#e34a08',
                            700: '#bc3509',
                            800: '#962b0f',
                            900: '#7a2510',
                        }
                    },
                    fontFamily: {
                        'figtree': ['Figtree', 'system-ui', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'card': '0 1px 3px 0 rgba(0, 0, 0, 0.05)',
                        'card-hover': '0 10px 30px -5px rgba(0, 0, 0, 0.1)',
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            font-family: 'Figtree', system-ui, sans-serif;
        }

        /* Sidebar Links */
        .sidebar-link {
            position: relative;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #f2650d 0%, #e34a08 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(242, 101, 13, 0.3);
        }

        .sidebar-link.active i {
            transform: scale(1.1);
        }

        .sidebar-link:hover:not(.active) {
            background-color: #fef6ee;
            color: #bc3509;
            transform: translateX(4px);
        }

        .sidebar-link:hover:not(.active) i {
            color: #f2650d;
        }

        /* Card Styles */
        .card-shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-shadow:hover {
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Table Rows */
        .table-row {
            transition: background-color 0.15s ease;
        }

        .table-row:hover {
            background-color: #fef6ee;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #f2650d 0%, #e34a08 100%);
            box-shadow: 0 2px 8px rgba(242, 101, 13, 0.2);
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #e34a08 0%, #bc3509 100%);
            box-shadow: 0 4px 12px rgba(242, 101, 13, 0.35);
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }

        /* Logo Animation */
        .logo-icon {
            transition: transform 0.3s ease;
        }

        .logo-icon:hover {
            transform: rotate(10deg) scale(1.1);
        }

        /* Badge Pulse */
        @keyframes pulse-ring {
            0% {
                transform: scale(0.95);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }
            100% {
                transform: scale(0.95);
                opacity: 1;
            }
        }

        .notification-badge {
            animation: pulse-ring 2s ease-in-out infinite;
        }

        /* Focus States */
        button:focus-visible,
        a:focus-visible {
            outline: 2px solid #f2650d;
            outline-offset: 2px;
        }

        /* Dropdown */
        .dropdown-menu {
            backdrop-filter: blur(10px);
        }

        /* Header Gradient */
        .header-gradient {
            background: linear-gradient(135deg, #f2650d 0%, #e34a08 50%, #bc3509 100%);
        }

        /* Mobile Menu Backdrop */
        .mobile-backdrop {
            backdrop-filter: blur(4px);
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen antialiased" x-data="{ sidebarOpen: true, mobileMenuOpen: false }" x-cloak>
    <div class="flex min-h-screen">
        <!-- Sidebar Desktop -->
        <aside
            :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="hidden lg:flex flex-col bg-white border-r border-gray-100 shadow-soft transition-all duration-300 fixed h-full z-40"
        >
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-100 header-gradient">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center logo-icon">
                        <i class="fas fa-car text-white text-lg"></i>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="font-bold text-white text-lg tracking-tight">Auto-École</span>
                </div>
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="text-white/80 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10"
                >
                    <i class="fas" :class="sidebarOpen ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home w-6 text-lg"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Tableau de bord</span>
                </a>

                <a href="{{ route('admin.auto-ecole.users.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-6 text-lg"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Utilisateurs</span>
                </a>

                <a href="{{ route('admin.auto-ecole.sessions.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.sessions.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt w-6 text-lg"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Sessions</span>
                </a>

                <a href="{{ route('admin.auto-ecole.modules.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.modules.*') ? 'active' : '' }}">
                    <i class="fas fa-book w-6 text-lg"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Modules</span>
                </a>

                <a href="{{ route('admin.auto-ecole.chapitres.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.chapitres.*') ? 'active' : '' }}">
                    <i class="fas fa-book-open w-6 text-lg"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Chapitres</span>
                </a>

                <a href="{{ route('admin.auto-ecole.lecons.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.lecons.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap w-6 text-lg"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Leçons</span>
                </a>

                <a href="{{ route('admin.auto-ecole.quiz.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.quiz.*') ? 'active' : '' }}">
                    <i class="fas fa-question-circle w-6 text-lg"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Quiz</span>
                </a>

                <a href="{{ route('admin.auto-ecole.paiements.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.paiements.*') ? 'active' : '' }}">
                    <i class="fas fa-credit-card w-6 text-lg"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Paiements</span>
                </a>

                <a href="{{ route('admin.auto-ecole.codes-caisse.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.codes-caisse.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt w-6 text-lg"></i>
                    <span x-show="sidebarOpen" x-transition class="ml-3">Codes Caisse</span>
                </a>

                <div class="pt-4 mt-4 border-t border-gray-100">
                    <a href="{{ route('admin.auto-ecole.config.index') }}"
                       class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.config.*') || request()->routeIs('admin.auto-ecole.centres-examen.*') || request()->routeIs('admin.auto-ecole.lieux-pratique.*') || request()->routeIs('admin.auto-ecole.jours-pratique.*') ? 'active' : '' }}">
                        <i class="fas fa-cog w-6 text-lg"></i>
                        <span x-show="sidebarOpen" x-transition class="ml-3">Configuration</span>
                    </a>
                </div>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-gray-100" x-show="sidebarOpen" x-transition>
                <div class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-50 transition-colors cursor-pointer">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shadow-sm">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500">Administrateur</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div
            x-show="mobileMenuOpen"
            @click="mobileMenuOpen = false"
            class="lg:hidden fixed inset-0 bg-black/50 mobile-backdrop z-40"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        ></div>

        <!-- Mobile Sidebar -->
        <aside
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="lg:hidden fixed inset-y-0 left-0 w-64 bg-white shadow-2xl z-50"
        >
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-100 header-gradient">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center">
                        <i class="fas fa-car text-white text-lg"></i>
                    </div>
                    <span class="font-bold text-white text-lg tracking-tight">Auto-École</span>
                </div>
                <button @click="mobileMenuOpen = false" class="text-white/80 hover:text-white p-2 rounded-lg hover:bg-white/10 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <nav class="px-3 py-6 space-y-1 overflow-y-auto" style="max-height: calc(100vh - 8rem);">
                <a href="{{ route('dashboard') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home w-6 text-lg"></i>
                    <span class="ml-3">Tableau de bord</span>
                </a>
                <a href="{{ route('admin.auto-ecole.users.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users w-6 text-lg"></i>
                    <span class="ml-3">Utilisateurs</span>
                </a>
                <a href="{{ route('admin.auto-ecole.sessions.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.sessions.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt w-6 text-lg"></i>
                    <span class="ml-3">Sessions</span>
                </a>
                <a href="{{ route('admin.auto-ecole.modules.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.modules.*') ? 'active' : '' }}">
                    <i class="fas fa-book w-6 text-lg"></i>
                    <span class="ml-3">Modules</span>
                </a>
                <a href="{{ route('admin.auto-ecole.chapitres.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.chapitres.*') ? 'active' : '' }}">
                    <i class="fas fa-book-open w-6 text-lg"></i>
                    <span class="ml-3">Chapitres</span>
                </a>
                <a href="{{ route('admin.auto-ecole.lecons.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.lecons.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap w-6 text-lg"></i>
                    <span class="ml-3">Leçons</span>
                </a>
                <a href="{{ route('admin.auto-ecole.quiz.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.quiz.*') ? 'active' : '' }}">
                    <i class="fas fa-question-circle w-6 text-lg"></i>
                    <span class="ml-3">Quiz</span>
                </a>
                <a href="{{ route('admin.auto-ecole.paiements.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.paiements.*') ? 'active' : '' }}">
                    <i class="fas fa-credit-card w-6 text-lg"></i>
                    <span class="ml-3">Paiements</span>
                </a>
                <a href="{{ route('admin.auto-ecole.codes-caisse.index') }}"
                   class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.codes-caisse.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt w-6 text-lg"></i>
                    <span class="ml-3">Codes Caisse</span>
                </a>
                <div class="pt-4 mt-4 border-t border-gray-100">
                    <a href="{{ route('admin.auto-ecole.config.index') }}"
                       class="sidebar-link flex items-center px-3 py-2.5 rounded-xl text-gray-700 font-medium text-sm {{ request()->routeIs('admin.auto-ecole.config.*') ? 'active' : '' }}">
                        <i class="fas fa-cog w-6 text-lg"></i>
                        <span class="ml-3">Configuration</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'" class="flex-1 transition-all duration-300">
            <!-- Top Header -->
            <header class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-30">
                <div class="flex items-center justify-between h-16 px-4 lg:px-6">
                    <div class="flex items-center space-x-4">
                        <button @click="mobileMenuOpen = true" class="lg:hidden text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-lg lg:text-xl font-bold text-gray-900 tracking-tight">@yield('page-title', 'Administration')</h1>
                    </div>

                    <div class="flex items-center space-x-3">
                        <button class="relative text-gray-600 hover:text-primary-600 p-2 rounded-lg hover:bg-gray-100 transition-all">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full notification-badge"></span>
                        </button>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-primary-600 p-2 rounded-lg hover:bg-gray-100 transition-all">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center shadow-sm">
                                    <i class="fas fa-user text-white text-xs"></i>
                                </div>
                                <i class="fas fa-chevron-down text-xs hidden sm:block"></i>
                            </button>

                            <div
                                x-show="open"
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                class="absolute right-0 mt-2 w-56 bg-white/95 backdrop-blur-lg rounded-xl shadow-card-hover border border-gray-100 py-2 z-50 dropdown-menu"
                                style="display: none;"
                            >
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ auth()->user()->email ?? '' }}</p>
                                </div>
                                <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                    <i class="fas fa-user-cog w-5"></i>
                                    <span class="ml-2">Mon profil</span>
                                </a>
                                <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                    <i class="fas fa-cog w-5"></i>
                                    <span class="ml-2">Paramètres</span>
                                </a>
                                <hr class="my-2 border-gray-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt w-5"></i>
                                        <span class="ml-2">Déconnexion</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 lg:p-6 max-w-[1600px] mx-auto">
                <!-- Flash Messages -->
                @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3.5 rounded-xl flex items-start shadow-sm animate-slide-in" x-data="{ show: true }" x-show="show" x-transition>
                    <i class="fas fa-check-circle mr-3 text-green-500 mt-0.5 text-lg"></i>
                    <span class="flex-1 text-sm font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="text-green-500 hover:text-green-700 p-1 rounded-lg hover:bg-green-100 transition-colors ml-2">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3.5 rounded-xl flex items-start shadow-sm animate-slide-in" x-data="{ show: true }" x-show="show" x-transition>
                    <i class="fas fa-exclamation-circle mr-3 text-red-500 mt-0.5 text-lg"></i>
                    <span class="flex-1 text-sm font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="text-red-500 hover:text-red-700 p-1 rounded-lg hover:bg-red-100 transition-colors ml-2">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3.5 rounded-xl shadow-sm animate-slide-in" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle mr-3 text-red-500 mt-0.5 text-lg"></i>
                        <div class="flex-1">
                            <p class="font-semibold mb-2 text-sm">Erreurs de validation :</p>
                            <ul class="space-y-1.5">
                                @foreach($errors->all() as $error)
                                <li class="text-sm flex items-start">
                                    <span class="text-red-400 mr-2">•</span>
                                    <span>{{ $error }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show = false" class="text-red-500 hover:text-red-700 p-1 rounded-lg hover:bg-red-100 transition-colors ml-3">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
                @endif

                @yield('admin-content')
            </main>

            <!-- Footer -->
            <footer class="border-t border-gray-100 bg-white mt-auto">
                <div class="px-4 lg:px-6 py-4">
                    <p class="text-center text-sm text-gray-500">
                        © {{ date('Y') }} Auto-École. Tous droits réservés.
                    </p>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
