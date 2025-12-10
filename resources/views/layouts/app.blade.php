<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Custom color palette - Color Hunt: #1B3C53, #234C6A, #456882, #E3E3E3 */
            :root {
                --primary: #1B3C53;
                --secondary: #234C6A;
                --accent: #456882;
                --light: #E3E3E3;
            }
            
            .bg-primary { background-color: var(--primary); }
            .bg-secondary { background-color: var(--secondary); }
            .bg-accent { background-color: var(--accent); }
            .bg-light { background-color: var(--light); }
            
            .text-primary { color: var(--primary); }
            .text-secondary { color: var(--secondary); }
            .text-accent { color: var(--accent); }
            
            .border-primary { border-color: var(--primary); }
            .border-secondary { border-color: var(--secondary); }
            .border-accent { border-color: var(--accent); }
            
            .gradient-bg {
                background: #1B3C53;
            }
            
            .gradient-soft {
                background: linear-gradient(to bottom, #ffffff 0%, #f8fafb 100%);
            }
            
            .hover-lift {
                transition: all 0.3s ease;
            }
            
            .hover-lift:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(27, 60, 83, 0.15);
            }
            
            /* Smooth scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }
            
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }
            
            ::-webkit-scrollbar-thumb {
                background: var(--accent);
                border-radius: 4px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: var(--secondary);
            }

            /* Main Content Transition */
            .main-content {
                margin-left: 280px;
                transition: margin-left 0.3s ease;
            }

            .main-content.sidebar-collapsed {
                margin-left: 0;
            }

            /* Responsive untuk mobile */
            @media (max-width: 768px) {
                .main-content {
                    margin-left: 0 !important;
                }
            }
        </style>

        @stack('styles')

    </head>
    <body class="font-sans antialiased gradient-soft">
        <div class="min-h-screen" style="display: flex;">
            <!-- Sidebar -->
            @include('layouts.sidebar')
            
            <!-- Main Content Area -->
            <div class="main-content" id="mainContent" style="flex: 1; min-height: 100vh; display: flex; flex-direction: column;">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white/80 backdrop-blur-sm shadow-md border-b-2" style="border-bottom-color: var(--accent);">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <div class="flex items-center justify-between">
                                <h1 class="text-3xl font-bold text-primary">
                                    {{ $header }}
                                </h1>
                                <div class="h-1 w-20 rounded-full" style="background: var(--primary);"></div>
                            </div>
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="py-8 flex-1">
                    <div class="container mx-auto px-4">
                        <!-- Content wrapper with card style -->
                        <div class="bg-white rounded-2xl shadow-xl p-6 hover-lift border-t-4" style="border-top-color: var(--secondary);">
                            @yield('content')
                        </div>
                    </div>
                </main>

                <!-- Footer (optional) -->
                <footer class="mt-auto py-6 bg-white/50 backdrop-blur-sm" style="border-top: 1px solid var(--light);">
                    <div class="container mx-auto px-4 text-center">
                        <p class="text-sm text-gray-600">
                            Clinical Pathway © {{ date('Y') }}
                        </p>
                    </div>
                </footer>
            </div>
        </div>
        
        <!-- Modal Stack - Outside all wrappers -->
        @stack('modals')

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                timerProgressBar: true,
                iconColor: '#10b981',
                confirmButtonColor: '#1B3C53'
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#1B3C53'
            });
        </script>
        @endif

        @if($errors->any())
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                html: '<ul style="text-align: left; padding-left: 20px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#1B3C53'
            });
        </script>
        @endif

    </body>
</html>