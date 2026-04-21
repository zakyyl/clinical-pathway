<style>
    .sidebar {
        width: 280px;
        height: 100vh;
        background: #1B3C53;
        position: fixed;
        left: 0;
        top: 0;
        overflow-y: auto;
        box-shadow: 4px 0 20px rgba(27, 60, 83, 0.2);
        z-index: 1000;
        transition: transform 0.3s ease;
    }

    .sidebar.collapsed {
        transform: translateX(-280px);
    }

    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(227, 227, 227, 0.1);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(227, 227, 227, 0.3);
        border-radius: 3px;
    }

    .sidebar-header {
        padding: 24px 20px;
        border-bottom: 1px solid rgba(227, 227, 227, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #234C6A;
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        color: white;
        text-decoration: none;
        flex: 1;
    }

    .sidebar-logo-icon {
        width: 48px;
        height: 48px;
        background-image: url('{{ asset(' image/logorsb.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .sidebar-logo-text h1 {
        font-size: 20px;
        font-weight: bold;
        margin: 0;
        color: #E3E3E3;
    }

    .sidebar-logo-text p {
        font-size: 11px;
        margin: 0;
        color: rgba(227, 227, 227, 0.8);
        letter-spacing: 0.5px;
    }

    /* Toggle Button */
    .sidebar-toggle-btn {
        background: #456882;
        border: none;
        color: #E3E3E3;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .sidebar-toggle-btn:hover {
        background: #234C6A;
        transform: scale(1.05);
    }

    /* Floating Toggle Button */
    .floating-toggle {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1001;
        background: #234C6A;
        border: none;
        color: #E3E3E3;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(27, 60, 83, 0.4);
        transition: all 0.3s ease;
        pointer-events: auto;
    }

    .floating-toggle:hover {
        background: #456882;
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(27, 60, 83, 0.5);
    }

    /* Show floating button when needed */
    .floating-toggle.visible {
        display: flex !important;
    }

    /* Hide floating button explicitly */
    .floating-toggle.hidden {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
        pointer-events: none !important;
    }

    /* Mobile Overlay */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .sidebar-overlay.show {
        display: block;
        opacity: 1;
    }

    .sidebar-user {
        padding: 16px 20px;
        background: #234C6A;
        margin: 16px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid rgba(69, 104, 130, 0.3);
    }

    .sidebar-user-avatar {
        width: 48px;
        height: 48px;
        background: #456882;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
        color: #E3E3E3;
        border: 2px solid rgba(227, 227, 227, 0.2);
    }

    .sidebar-user-info h3 {
        font-size: 14px;
        font-weight: 600;
        margin: 0;
        color: #E3E3E3;
    }

    .sidebar-user-info p {
        font-size: 12px;
        margin: 2px 0 0 0;
        color: rgba(227, 227, 227, 0.7);
    }

    .sidebar-nav {
        padding: 8px 16px 24px 16px;
    }

    .sidebar-nav-section {
        margin-bottom: 24px;
    }

    .sidebar-nav-title {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: rgba(227, 227, 227, 0.5);
        padding: 0 12px;
        margin-bottom: 8px;
        letter-spacing: 1px;
    }

    .sidebar-menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        margin-bottom: 4px;
        border-radius: 10px;
        color: rgba(227, 227, 227, 0.9);
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .sidebar-menu-item:hover {
        background: #234C6A;
        color: #E3E3E3;
        transform: translateX(4px);
    }

    .sidebar-menu-item.active {
        background: #456882;
        color: #E3E3E3;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .sidebar-menu-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: #E3E3E3;
        border-radius: 0 4px 4px 0;
    }

    .sidebar-menu-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .sidebar-menu-text {
        flex: 1;
        font-size: 14px;
    }

    .sidebar-footer {
        padding: 16px 20px;
        border-top: 1px solid rgba(227, 227, 227, 0.1);
        margin-top: auto;
    }

    .sidebar-footer-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 10px;
        color: rgba(227, 227, 227, 0.9);
        text-decoration: none;
        transition: all 0.3s ease;
        background: #234C6A;
    }

    .sidebar-footer-btn:hover {
        background: #456882;
        color: #E3E3E3;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-280px);
        }

        .sidebar.show {
            transform: translateX(0);
        }
    }

    @media (max-width: 480px) {
        .floating-toggle {
            top: 16px;
            left: 16px;
            width: 44px;
            height: 44px;
        }
    }
</style>

<!-- Floating Toggle Button -->
<button class="floating-toggle" id="floatingToggle" onclick="toggleSidebar()" type="button">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard.index') }}" class="sidebar-logo">
            <div class="sidebar-logo-icon"></div>
            <div class="sidebar-logo-text">
                <h1>Clinical Pathway</h1>
            </div>
        </a>
        <button class="sidebar-toggle-btn" onclick="toggleSidebar()" title="Toggle Sidebar" type="button">
            <i class="fas fa-angle-double-left"></i>
        </button>
    </div>

    <div class="sidebar-user">
        <div class="sidebar-user-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div class="sidebar-user-info">
            <h3>{{ Auth::user()->name }}</h3>
            <p>{{ Auth::user()->email }}</p>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-nav-section">
            <div class="sidebar-nav-title">Main Menu</div>

            <a href="{{ route('dashboard.index') }}"
                class="sidebar-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="sidebar-menu-icon"><i class="fas fa-home"></i></span>
                <span class="sidebar-menu-text">Dashboard</span>
            </a>
        </div>

        <div class="sidebar-nav-section">
            <div class="sidebar-nav-title">Daftar Pathway</div>

            <a href="{{ route('hiv.index') }}"
                class="sidebar-menu-item {{ request()->routeIs('hiv.*') ? 'active' : '' }}">
                <span class="sidebar-menu-icon"><i class="fas fa-virus"></i></span>
                <span class="sidebar-menu-text">HIV</span>
            </a>

            <a href="{{ route('bph.index') }}"
                class="sidebar-menu-item {{ request()->routeIs('bph.*') ? 'active' : '' }}">
                <span class="sidebar-menu-icon"><i class="fas fa-male"></i></span>
                <span class="sidebar-menu-text">BPH</span>
            </a>

            <a href="{{ route('peb.index') }}"
                class="sidebar-menu-item {{ request()->routeIs('peb.*') ? 'active' : '' }}">
                <span class="sidebar-menu-icon"><i class="fas fa-baby"></i></span>
                <span class="sidebar-menu-text">PEB</span>
            </a>

            <a href="{{ route('dm.index') }}"
                class="sidebar-menu-item {{ request()->routeIs('dm.*') ? 'active' : '' }}">
                <span class="sidebar-menu-icon"><i class="fas fa-syringe"></i></span>
                <span class="sidebar-menu-text">Diabetes</span>
            </a>

            <a href="{{ route('jntg.index') }}"
                class="sidebar-menu-item {{ request()->routeIs('jntg.*') ? 'active' : '' }}">
                <span class="sidebar-menu-icon"><i class="fas fa-heartbeat"></i></span>
                <span class="sidebar-menu-text">Jantung</span>
            </a>

            <a href="{{ route('typh.index') }}"
                class="sidebar-menu-item {{ request()->routeIs('typh.*') ? 'active' : '' }}">
                <span class="sidebar-menu-icon"><i class="fas fa-thermometer-half"></i></span>
                <span class="sidebar-menu-text">Typhoid Anak</span>
            </a>

            <a href="{{ route('dyps.index') }}"
                class="sidebar-menu-item {{ request()->routeIs('dyps.*') ? 'active' : '' }}">
                <span class="sidebar-menu-icon"><i class="fas fa-lungs-virus"></i></span>
                <span class="sidebar-menu-text">Dyspepsia</span>
            </a>

            <a href="{{ route('htsi.index') }}"
                class="sidebar-menu-item {{ request()->routeIs('htsi.*') ? 'active' : '' }}">
                <span class="sidebar-menu-icon"><i class="fas fa-tint"></i></span>
                <span class="sidebar-menu-text">Hipertensi</span>
            </a>
        </div>

        <div class="sidebar-nav-section">
            <div class="sidebar-nav-title">Laporan</div>

            <a href="{{ route('statistik.index') }}"
                class="sidebar-menu-item {{ request()->routeIs('statistik.*') ? 'active' : '' }}">
                <span class="sidebar-menu-icon"><i class="fas fa-chart-line"></i></span>
                <span class="sidebar-menu-text">Statistik</span>
            </a>
        </div>

        @if(Auth::user()->role === 'admin')
        <div class="sidebar-nav-section">
            <div class="sidebar-nav-title">Setting</div>

            <a href="{{ route('users.index') }}"
                class="sidebar-menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <span class="sidebar-menu-icon"><i class="fa-solid fa-gears"></i></span>
                <span class="sidebar-menu-text">User</span>
            </a>
        </div>
        @endif
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-footer-btn"
                style="width: 100%; border: none; cursor: pointer; font-family: inherit;">
                <span class="sidebar-menu-icon"><i class="fas fa-sign-out-alt"></i></span>
                <span class="sidebar-menu-text">Logout</span>
            </button>
        </form>
    </div>
</aside>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const floatingToggle = document.getElementById('floatingToggle');
        const overlay = document.getElementById('sidebarOverlay');
        const isMobile = window.innerWidth <= 768;
        
        if (isMobile) {
            const isOpen = sidebar.classList.contains('show');
            
            if (isOpen) {
                // Close sidebar
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                // Show button
                floatingToggle.classList.remove('hidden');
                floatingToggle.classList.add('visible');
                document.body.style.overflow = 'auto';
            } else {
                // Open sidebar
                sidebar.classList.add('show');
                overlay.classList.add('show');
                // Hide button
                floatingToggle.classList.remove('visible');
                floatingToggle.classList.add('hidden');
                document.body.style.overflow = 'hidden';
            }
        } else {
            // Desktop behavior
            sidebar.classList.toggle('collapsed');
            if (mainContent) {
                mainContent.classList.toggle('sidebar-collapsed');
            }
            floatingToggle.classList.toggle('visible');
            
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        }
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const floatingToggle = document.getElementById('floatingToggle');
        
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        floatingToggle.classList.remove('hidden');
        floatingToggle.classList.add('visible');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const floatingToggle = document.getElementById('floatingToggle');
        const isMobile = window.innerWidth <= 768;
        
        if (isMobile) {
            // Mobile: show button, hide sidebar
            floatingToggle.classList.add('visible');
            sidebar.classList.remove('show');
        } else {
            // Desktop: restore state
            const collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (collapsed) {
                sidebar.classList.add('collapsed');
                if (mainContent) {
                    mainContent.classList.add('sidebar-collapsed');
                }
                floatingToggle.classList.add('visible');
            }
        }
        
        // Auto-close on menu click (mobile)
        document.querySelectorAll('.sidebar-menu-item').forEach(item => {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    setTimeout(closeSidebar, 100);
                }
            });
        });
    });

    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        const floatingToggle = document.getElementById('floatingToggle');
        const overlay = document.getElementById('sidebarOverlay');
        const isMobile = window.innerWidth <= 768;
        
        if (isMobile) {
            const isOpen = sidebar.classList.contains('show');
            if (isOpen) {
                floatingToggle.classList.add('hidden');
                floatingToggle.classList.remove('visible');
            } else {
                floatingToggle.classList.remove('hidden');
                floatingToggle.classList.add('visible');
            }
        } else {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = 'auto';
            
            const collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (collapsed) {
                floatingToggle.classList.add('visible');
            } else {
                floatingToggle.classList.remove('visible');
            }
        }
    });
</script>