<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Canteen Express') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d'
                        },
                        accent: {
                            400: '#f59e0b',
                            500: '#f59e0b',
                            600: '#d97706'
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'card-entrance': 'cardSlideUp 0.6s ease-out',
                        'scale-in': 'scaleIn 0.3s ease-out',
                        'pulse-soft': 'pulseSoft 2s infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            'from': { opacity: '0' },
                            'to': { opacity: '1' }
                        },
                        slideUp: {
                            'from': { opacity: '0', transform: 'translateY(20px)' },
                            'to': { opacity: '1', transform: 'translateY(0)' }
                        },
                        cardSlideUp: {
                            'from': { transform: 'translateY(30px)', opacity: '0' },
                            'to': { transform: 'translateY(0)', opacity: '1' }
                        },
                        scaleIn: {
                            'from': { transform: 'scale(0.95)', opacity: '0' },
                            'to': { transform: 'scale(1)', opacity: '1' }
                        },
                        pulseSoft: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '0.5' }
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-800;
        }

        ::-webkit-scrollbar-thumb {
            @apply bg-gray-300 dark:bg-gray-600 rounded-full;
        }

        ::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-400 dark:bg-gray-500;
        }

        .dark {
            color-scheme: dark;
        }

        *,
        *::before,
        *::after {
            transition: background-color 0.3s ease,
                border-color 0.3s ease,
                color 0.3s ease,
                transform 0.3s ease,
                opacity 0.3s ease;
        }

        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid currentColor;
            border-radius: 50%;
            border-right-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .nav-item.active {
            @apply bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400;
            border-right: 2px solid theme('colors.green.500');
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .dark .card-hover:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }

        .toast {
            transition: all 0.3s ease;
        }

        .toast-enter {
            animation: toastSlideIn 0.3s ease-out forwards;
        }

        .toast-leave {
            animation: toastSlideOut 0.3s ease-out forwards;
        }

        @keyframes toastSlideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes toastSlideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* View toggle button styles */
        .view-toggle {
            transition: all 0.2s ease;
        }
        
        .view-toggle.active {
            transform: scale(1.05);
        }
        
        /* Responsive table improvements */
        @media (max-width: 640px) {
            /* Hide table view on mobile by default */
            #table-view {
                display: none;
            }
            
            /* Show card view on mobile by default */
            #card-view {
                display: block !important;
            }
            
            /* Improve table scroll on very small screens */
            .table-container {
                -webkit-overflow-scrolling: touch;
            }
            
            /* Better mobile table styling */
            table {
                min-width: 700px;
            }
            
            th, td {
                white-space: nowrap;
            }
            
            /* Sticky columns for mobile */
            .sticky {
                position: sticky;
                z-index: 10;
            }
        }
        
        @media (min-width: 641px) {
            /* Hide view toggle buttons on desktop */
            .view-toggle {
                display: none;
            }
            
            /* Show table view on desktop by default */
            #table-view {
                display: block;
            }
            
            /* Hide card view on desktop by default */
            #card-view {
                display: none !important;
            }
            
            /* Remove sticky positioning on desktop */
            .sticky {
                position: static;
            }
        }
        
        /* Card hover effects */
        .user-card {
            transition: all 0.3s ease;
        }
        
        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .dark .user-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
        
        /* Smooth transitions for view switching */
        #table-view, #card-view {
            transition: opacity 0.3s ease;
        }
        
        /* Better mobile form styling */
        @media (max-width: 640px) {
            .modal-content {
                margin: 1rem;
                max-height: calc(100vh - 2rem);
            }
        }
        
        /* Loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
            position: relative;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #22c55e;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        /* Better focus states for accessibility */
        .user-card:focus-within,
        .card:focus-within {
            ring: 2px;
            ring-color: #22c55e;
            ring-opacity: 0.5;
        }
        
        /* Responsive text sizing */
        @media (max-width: 480px) {
            .user-card h4,
            .card h4 {
                font-size: 0.875rem;
            }
            
            .user-card .text-sm,
            .card .text-sm {
                font-size: 0.75rem;
            }
        }
        
        /* Form validation states */
        .border-red-300 {
            border-color: #fca5a5 !important;
        }
        
        .ring-red-200 {
            ring-color: #fecaca !important;
            ring-width: 2px !important;
        }
        
        /* Improved button states */
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        /* Better mobile pagination */
        @media (max-width: 640px) {
            .pagination-text {
                font-size: 0.75rem;
            }
            
            .pagination-button {
                min-width: 32px;
                height: 32px;
                padding: 0.25rem;
            }
        }
        
        /* Tooltip styling */
        [title] {
            position: relative;
        }
        
        /* Improved table scroll shadow */
        .table-container {
            background: 
                /* Shadow covers */ 
                linear-gradient(90deg, rgba(255,255,255,1) 30%, rgba(255,255,255,0)) left,
                linear-gradient(90deg, rgba(255,255,255,0), rgba(255,255,255,1) 70%) right;
            background-repeat: no-repeat;
            background-color: white;
            background-size: 40px 100%, 40px 100%;
            background-attachment: local, local;
        }
        
        .dark .table-container {
            background: 
                linear-gradient(90deg, rgba(31,41,55,1) 30%, rgba(31,41,55,0)) left,
                linear-gradient(90deg, rgba(31,41,55,0), rgba(31,41,55,1) 70%) right;
            background-repeat: no-repeat;
            background-color: rgb(31 41 55);
            background-size: 40px 100%, 40px 100%;
            background-attachment: local, local;
        }

        /* Custom animations */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        .animate-bounce-in {
            animation: bounceIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* SweetAlert2 Dark Mode Styles */
        .dark .swal2-popup {
            @apply bg-gray-800 border border-gray-700;
        }

        .dark .swal2-title {
            @apply text-white;
        }

        .dark .swal2-html-container {
            @apply text-gray-300;
        }

        .dark .swal2-confirm {
            @apply bg-green-600 hover:bg-green-700;
        }

        .dark .swal2-cancel {
            @apply bg-gray-600 hover:bg-gray-700;
        }
    </style>

    @stack('styles')

    <script>
        (function() {
            const theme = localStorage.getItem('theme') ||
                (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
            } else {
                document.documentElement.classList.add('light');
                document.body.classList.add('light');
            }
        })();
    </script>
</head>

<body class="h-full bg-gray-50 dark:bg-gray-900 transition-colors duration-300 font-sans" onclick="enableSound()">
    <div class="min-h-screen flex">
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 dark:bg-black/70 z-40 lg:hidden hidden backdrop-blur-sm transition-all duration-300">
        </div>

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="lg:ml-64 flex-1 flex flex-col min-h-screen">
            <!-- Top Header -->
            @include('layouts.header')

            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 space-y-6 sm:space-y-8">
                @yield('content')
            </main>
        </div>
    </div>

    <div id="toast-container" class="fixed top-4 right-4 z-[9999] space-y-2"></div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

    <script>
        // ==============================================
        // CONFIRMATION FUNCTIONS
        // ==============================================

        window.showConfirmation = function(options = {}) {
            const defaultOptions = {
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin melanjutkan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#22c55e',
                cancelButtonColor: '#6b7280',
                reverseButtons: true,
                focusCancel: true,
                allowOutsideClick: false,
                allowEscapeKey: true,
                backdrop: true,
                customClass: {
                    popup: 'animate-fade-in',
                    confirmButton: 'px-4 py-2 text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2',
                    cancelButton: 'px-4 py-2 text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2'
                }
            };

            const finalOptions = { ...defaultOptions, ...options };
            return Swal.fire(finalOptions);
        };

        window.confirmDelete = function(options = {}) {
            const deleteOptions = {
                title: 'Konfirmasi Hapus',
                text: options.text || 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                reverseButtons: true,
                focusCancel: true,
                ...options
            };

            return window.showConfirmation(deleteOptions);
        };

        window.submitFormWithConfirmation = function(formSelector, confirmOptions = {}) {
            const form = document.querySelector(formSelector);
            if (!form) {
                console.error('Form not found:', formSelector);
                return;
            }

            window.showConfirmation(confirmOptions).then((result) => {
                if (result.isConfirmed) {
                    const submitButton = form.querySelector('button[type="submit"]');
                    if (submitButton) {
                        const originalText = submitButton.innerHTML;
                        submitButton.innerHTML = '<span class="loading-spinner mr-2"></span>Memproses...';
                        submitButton.disabled = true;

                        setTimeout(() => {
                            if (submitButton) {
                                submitButton.innerHTML = originalText;
                                submitButton.disabled = false;
                            }
                        }, 10000);
                    }

                    form.submit();
                }
            });
        };

        window.handleActionWithConfirmation = async function(element) {
    const action = element.dataset.action;
    const method = element.dataset.method || 'POST';

    if (!action) return;

    const result = await Swal.fire({
        title: 'Konfirmasi Hapus',
        text: 'Data ini akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        reverseButtons: true,
        focusCancel: true
    });

    // 🔥 PENTING: handle semua kondisi
    if (!result.isConfirmed) {
        return; // langsung keluar tanpa ngapa-ngapain
    }

    // lanjut delete
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = action;

    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
    form.appendChild(csrfInput);

    if (method !== 'POST') {
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = method;
        form.appendChild(methodInput);
    }

    document.body.appendChild(form);
    form.submit();
};

        // ==============================================
        // TOAST NOTIFICATION SYSTEM
        // ==============================================

        window.showToast = function(message, type = 'info', duration = 5000, options = {}) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            const toastId = 'toast-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
            toast.id = toastId;

            const bgColors = {
                success: 'bg-purple-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };

            const titles = {
                success: 'Berhasil',
                error: 'Gagal',
                warning: 'Peringatan',
                info: 'Informasi'
            };

            toast.className = `toast min-w-[320px] max-w-md p-4 rounded-lg shadow-xl ${bgColors[type] || bgColors.info} text-white transform translate-x-full transition-all duration-300`;

            const title = options.title || titles[type] || titles.info;
            const showProgress = duration > 0 && (options.showProgress !== false);

            toast.innerHTML = `
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas ${icons[type] || icons.info} text-lg"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        ${title ? `<p class="text-sm font-semibold">${title}</p>` : ''}
                        <p class="text-sm ${title ? 'mt-1' : ''}">${message}</p>
                    </div>
                    <button onclick="window.dismissToast('${toastId}')" class="ml-4 flex-shrink-0 text-white hover:text-gray-200 focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                ${showProgress ? `<div class="toast-progress mt-3 h-1 bg-white/30 rounded-full overflow-hidden"><div class="h-full bg-white/70 rounded-full transition-all duration-linear" style="width: 100%; transition-duration: ${duration}ms;"></div></div>` : ''}
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-x-full');
                toast.classList.add('translate-x-0');

                if (showProgress) {
                    const progressBar = toast.querySelector('.toast-progress > div');
                    if (progressBar) {
                        setTimeout(() => {
                            progressBar.style.width = '0%';
                        }, 100);
                    }
                }
            }, 10);

            if (duration > 0) {
                setTimeout(() => {
                    window.dismissToast(toastId);
                }, duration);
            }

            return toastId;
        };

        window.dismissToast = function(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.classList.add('translate-x-full');
                toast.classList.remove('translate-x-0');

                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 300);
            }
        };

        // ==============================================
        // SIDEBAR MANAGEMENT
        // ==============================================

        class SidebarManager {
            constructor() {
                this.sidebarOpen = false;
                this.init();
            }

            init() {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const closeSidebar = document.getElementById('close-sidebar');
                const sidebarOverlay = document.getElementById('sidebar-overlay');

                if (mobileMenuButton) {
                    mobileMenuButton.addEventListener('click', (e) => {
                        e.preventDefault();
                        this.openSidebar();
                    });
                }

                if (closeSidebar) {
                    closeSidebar.addEventListener('click', (e) => {
                        e.preventDefault();
                        this.closeSidebar();
                    });
                }

                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', () => {
                        this.closeSidebar();
                    });
                }

                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        this.closeSidebar();
                    }
                });

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && this.sidebarOpen) {
                        this.closeSidebar();
                    }
                });
            }

            openSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');

                if (sidebar && overlay) {
                    this.sidebarOpen = true;
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            }

            closeSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');

                if (sidebar && overlay) {
                    this.sidebarOpen = false;
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
        }

        // ==============================================
        // THEME MANAGEMENT
        // ==============================================

        class ThemeManager {
            constructor() {
                this.currentTheme = this.getStoredTheme();
                this.init();
            }

            getStoredTheme() {
                const stored = localStorage.getItem('theme');
                if (stored) return stored;

                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    return 'dark';
                }

                return 'light';
            }

            init() {
                this.setTheme(this.currentTheme);

                const themeToggle = document.getElementById('theme-toggle');
                if (themeToggle) {
                    themeToggle.addEventListener('click', () => this.toggleTheme());
                }
            }

            setTheme(theme) {
                this.currentTheme = theme;
                const html = document.documentElement;
                const body = document.body;
                const themeIcon = document.getElementById('theme-icon');

                html.classList.remove('dark', 'light');
                body.classList.remove('dark', 'light');

                if (theme === 'dark') {
                    html.classList.add('dark');
                    body.classList.add('dark');

                    if (themeIcon) {
                        themeIcon.className = 'fas fa-sun text-yellow-400';
                    }
                } else {
                    html.classList.add('light');
                    body.classList.add('light');

                    if (themeIcon) {
                        themeIcon.className = 'fas fa-moon text-gray-600 dark:text-gray-300';
                    }
                }

                localStorage.setItem('theme', theme);
            }

            toggleTheme() {
                const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
                this.setTheme(newTheme);
                showToast(newTheme === 'dark' ? 'Mode gelap diaktifkan' : 'Mode terang diaktifkan', 'info', 2000);
            }
        }

        // ==============================================
        // PROFILE DROPDOWN
        // ==============================================

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            const arrow = document.getElementById('dropdown-arrow');

            if (dropdown) {
                if (dropdown.classList.contains('hidden')) {
                    dropdown.classList.remove('hidden');
                    setTimeout(() => {
                        dropdown.classList.remove('opacity-0', 'scale-95');
                        dropdown.classList.add('opacity-100', 'scale-100');
                    }, 10);

                    if (arrow) {
                        arrow.style.transform = 'rotate(180deg)';
                    }
                } else {
                    closeProfileDropdown();
                }
            }
        }

        function closeProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            const arrow = document.getElementById('dropdown-arrow');

            if (dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('opacity-0', 'scale-95');
                dropdown.classList.remove('opacity-100', 'scale-100');

                setTimeout(() => {
                    dropdown.classList.add('hidden');
                }, 200);

                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
        }

        function logout() {
            window.showConfirmation({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'question',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/logout';
                    form.innerHTML = '<input type="hidden" name="_token" value="' + document.querySelector('meta[name="csrf-token"]').getAttribute('content') + '">';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        window.copyToClipboard = function(text, message = 'Teks berhasil disalin!') {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function() {
                    showToast(message, 'success', 3000);
                }, function(err) {
                    console.error('Could not copy text: ', err);
                    const textArea = document.createElement("textarea");
                    textArea.value = text;
                    textArea.style.position = "fixed";
                    textArea.style.left = "-999999px";
                    textArea.style.top = "-999999px";
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        showToast(message, 'success', 3000);
                    } catch (err) {
                        showToast('Gagal menyalin teks', 'error');
                    }
                    textArea.remove();
                });
            } else {
                const textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.position = "fixed";
                textArea.style.left = "-999999px";
                textArea.style.top = "-999999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    showToast(message, 'success', 3000);
                } catch (err) {
                    showToast('Gagal menyalin teks', 'error');
                }
                textArea.remove();
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            window.themeManager = new ThemeManager();
            window.sidebarManager = new SidebarManager();

            document.addEventListener('click', (event) => {
                const profileDropdown = document.getElementById('profile-dropdown');
                const profileButton = document.getElementById('user-profile-button');

                if (profileDropdown && profileButton) {
                    if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                        closeProfileDropdown();
                    }
                }
            });
        });
    </script>

    <script>
    let soundEnabled = false;

    function enableSound() {
        soundEnabled = true;

        const audio = document.getElementById('notifSound');
        if (audio) {
            audio.play().then(() => {
                audio.pause();
                audio.currentTime = 0;
            }).catch(() => {});
        }
    }
</script>
</body>
</html>