<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['judul']; ?> - UangKas</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .sidebar-link.active {
            background-color: #4f46e5;
            color: white;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
    </style>
</head>
<body class="flex min-h-screen bg-slate-50 relative overflow-x-hidden">
    
    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 z-40 hidden md:hidden transition-opacity opacity-0" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-indigo-950 text-indigo-200 flex-shrink-0 flex flex-col fixed md:sticky top-0 left-0 h-screen z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 shadow-2xl">
        <div class="p-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-500 p-2 rounded-xl">
                    
                </div>
                <span class="text-xl font-bold text-white tracking-tight">UangKas</span>
            </div>
            <!-- Mobile Close Button -->
            <button class="md:hidden text-slate-400 hover:text-white p-2 font-bold" onclick="toggleSidebar()">
                X
            </button>
        </div>
        
        <nav class="flex-1 px-4 space-y-2 py-4 overflow-y-auto">
            <a href="<?= BASEURL; ?>/dashboard" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all hover:bg-white/10 <?= $data['judul'] == 'Dashboard' ? 'active' : '' ?>">
                
                <span class="font-medium">Dashboard</span>
            </a>
            <a href="<?= BASEURL; ?>/murid" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all hover:bg-white/10 <?= $data['judul'] == 'Daftar Murid' ? 'active' : '' ?>">
                
                <span class="font-medium">Murid</span>
            </a>
            <a href="<?= BASEURL; ?>/kas" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all hover:bg-white/10 <?= $data['judul'] == 'Uang Kas Mingguan' ? 'active' : '' ?>">
                
                <span class="font-medium">Uang Kas</span>
            </a>
            <a href="<?= BASEURL; ?>/kategori" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all hover:bg-white/10 <?= $data['judul'] == 'Kategori Transaksi' ? 'active' : '' ?>">
                
                <span class="font-medium">Kategori</span>
            </a>
            <a href="<?= BASEURL; ?>/transaksi" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all hover:bg-white/10 <?= $data['judul'] == 'Data Transaksi' ? 'active' : '' ?>">
                
                <span class="font-medium">Transaksi</span>
            </a>
            <a href="<?= BASEURL; ?>/log" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all hover:bg-white/10 <?= $data['judul'] == 'Log Aktivitas' ? 'active' : '' ?>">
                
                <span class="font-medium">Log Aktivitas</span>
            </a>
        </nav>
        
        <div class="p-4 border-t border-indigo-900/50 mt-auto">
            <div class="bg-white/5 rounded-2xl p-4 flex items-center gap-3 relative group border border-white/5">
                <a href="<?= BASEURL; ?>/profil" class="absolute inset-0 z-10 rounded-2xl ring-2 ring-transparent group-hover:ring-indigo-500 transition-all"></a>
                <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold shrink-0">
                    <?= substr(htmlspecialchars($_SESSION['user']['nama'], ENT_QUOTES, 'UTF-8'), 0, 1); ?>
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-semibold text-white truncate"><?= htmlspecialchars($_SESSION['user']['nama'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p class="text-xs text-indigo-300 capitalize"><?= htmlspecialchars($_SESSION['user']['role'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <a href="<?= BASEURL; ?>/auth/logout" class="text-slate-400 hover:text-red-400 z-20 relative p-2 font-bold" title="Logout">
                    Keluar
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <!-- Top Header -->
        <header class="h-16 bg-white border-b border-slate-100 flex items-center justify-between px-4 md:px-8 flex-shrink-0 z-30">
            <div class="flex items-center gap-3 md:gap-4">
                <button class="md:hidden p-2 text-slate-600 hover:text-indigo-600 font-bold bg-slate-100 rounded-lg flex items-center gap-2" onclick="toggleSidebar()">
                    <span>Menu</span>
                </button>
                <h2 class="text-lg font-bold text-slate-800"><?= $data['judul']; ?></h2>
            </div>
            <div class="flex items-center gap-4">
                <p class="text-sm text-slate-500 font-medium hidden sm:block"><?= date('l, d F Y'); ?></p>
            </div>
        </header>

        <!-- Scrollable Body -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8 space-y-6 md:space-y-8 pb-20">

        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                
                if (sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('opacity-0');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                }
            }
        </script>
