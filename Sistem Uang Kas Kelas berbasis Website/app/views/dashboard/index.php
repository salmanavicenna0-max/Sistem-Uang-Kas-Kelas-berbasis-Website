<?php require_once '../app/views/templates/header.php'; ?>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Card 1: Saldo -->
    <div class="bg-indigo-600 rounded-3xl p-6 text-white shadow-lg shadow-indigo-200 relative overflow-hidden group">
        <div class="relative z-10">
            <p class="text-indigo-100 text-sm font-medium mb-1">Total Saldo Kas</p>
            <h3 class="text-3xl font-bold">Rp <?= number_format($data['saldo'], 0, ',', '.'); ?></h3>
            <div class="mt-4 flex items-center gap-2 text-indigo-100 text-xs">
                <span class="bg-indigo-500 bg-opacity-30 px-2 py-1 rounded-full">Updated just now</span>
            </div>
        </div>
    </div>

    <!-- Card 2: Masuk -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border relative overflow-hidden group">
        <div class="relative z-10">
            <p class="text-slate-500 text-sm font-medium mb-1">Total Pemasukan</p>
            <h3 class="text-3xl font-bold text-slate-800">Rp <?= number_format($data['total_masuk'], 0, ',', '.'); ?></h3>
            <div class="mt-4 flex items-center gap-2 text-emerald-600 text-xs font-bold uppercase tracking-wider">
                
                <span>Credit Jurnal</span>
            </div>
        </div>
        
    </div>

    <!-- Card 3: Keluar -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border relative overflow-hidden group">
        <div class="relative z-10">
            <p class="text-slate-500 text-sm font-medium mb-1">Total Pengeluaran</p>
            <h3 class="text-3xl font-bold text-slate-800">Rp <?= number_format($data['total_keluar'], 0, ',', '.'); ?></h3>
            <div class="mt-4 flex items-center gap-2 text-rose-600 text-xs font-bold uppercase tracking-wider">
                
                <span>Debit Jurnal</span>
            </div>
        </div>
        
    </div>

    <!-- Card 4: Murid -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border relative overflow-hidden group">
        <div class="relative z-10">
            <p class="text-slate-500 text-sm font-medium mb-1">Total Murid</p>
            <h3 class="text-3xl font-bold text-slate-800"><?= $data['jumlah_murid']; ?> Siswa</h3>
            <div class="mt-4 flex items-center gap-2 text-slate-400 text-xs font-medium">
                
                <span>Aktif di Database</span>
            </div>
        </div>
        
    </div>
</div>

<!-- Charts & Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Chart Section -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white p-8 rounded-3xl shadow-sm border">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h4 class="font-bold text-slate-800 text-lg">Ikhtisar Keuangan</h4>
                    <p class="text-slate-400 text-sm">Visualisasi perbandingan masuk & keluar</p>
                </div>
                <div class="flex gap-2">
                    <span class="flex items-center gap-1 text-xs font-medium text-slate-500">
                        <span class="w-3 h-3 bg-indigo-500 rounded-full"></span> Masuk
                    </span>
                    <span class="flex items-center gap-1 text-xs font-medium text-slate-500">
                        <span class="w-3 h-3 bg-emerald-400 rounded-full"></span> Keluar
                    </span>
                </div>
            </div>
            <canvas id="mainChart" height="120"></canvas>
        </div>

        <!-- Recent Logs (Transparency) -->
        <div class="bg-white rounded-3xl shadow-sm border overflow-hidden">
            <div class="p-6 border-b flex items-center justify-between">
                <h4 class="font-bold text-slate-800">Aktivitas Terkini</h4>
                <a href="<?= BASEURL; ?>/log" class="text-indigo-600 text-xs font-bold hover:underline">Lihat Semua</a>
            </div>
            <div class="divide-y">
                <?php foreach($data['recent_logs'] as $log) : ?>
                <div class="p-4 flex items-start gap-4 hover:bg-slate-50 transition-colors">
                    <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center 
                        <?= $log['aksi'] == 'delete' ? 'bg-red-50 text-red-500' : ($log['aksi'] == 'insert' ? 'bg-emerald-50 text-emerald-500' : 'bg-indigo-50 text-indigo-500') ?>">
                        
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate uppercase tracking-tighter">Transaksi <?= $log['aksi']; ?></p>
                        <p class="text-xs text-slate-500 mt-1">ID Transaksi: #<?= $log['transaksi_id']; ?></p>
                        <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold tracking-tighter">
                             <?= date('d M Y, H:i', strtotime($log['created_at'])); ?> 
                            <span class="mx-2">•</span> 
                             Oleh: <?= $log['nama_user']; ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Right Side: Distribution -->
    <div class="space-y-8">
        <div class="bg-white p-8 rounded-3xl shadow-sm border">
            <h4 class="font-bold text-slate-800 mb-6">Distribusi Dana</h4>
            <div class="relative flex items-center justify-center">
                <canvas id="pieChart"></canvas>
            </div>
            <div class="mt-8 space-y-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500">Pemasukan</span>
                    <span class="font-bold text-slate-800">Rp <?= number_format($data['total_masuk'], 0, ',', '.'); ?></span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-indigo-500 h-full" style="width: <?= $data['total_masuk'] > 0 ? ($data['total_masuk'] / ($data['total_masuk'] + $data['total_keluar'] ?: 1) * 100) : 0 ?>%"></div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-500">Pengeluaran</span>
                    <span class="font-bold text-slate-800">Rp <?= number_format($data['total_keluar'], 0, ',', '.'); ?></span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-emerald-400 h-full" style="width: <?= $data['total_keluar'] > 0 ? ($data['total_keluar'] / ($data['total_masuk'] + $data['total_keluar'] ?: 1) * 100) : 0 ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Quick Access -->
        <div class="bg-indigo-600 rounded-3xl p-8 text-white shadow-lg shadow-indigo-100">
            <h4 class="font-bold mb-4">Aksi Cepat</h4>
            <div class="grid grid-cols-2 gap-3">
                <a href="<?= BASEURL; ?>/transaksi" class="bg-white/10 hover:bg-white/20 p-4 rounded-2xl transition-colors text-center border border-white/10">
                    
                    <span class="text-xs font-medium">Transaksi</span>
                </a>
                <a href="<?= BASEURL; ?>/murid" class="bg-white/10 hover:bg-white/20 p-4 rounded-2xl transition-colors text-center border border-white/10">
                    
                    <span class="text-xs font-medium">Murid</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Main Bar Chart
    const ctx = document.getElementById('mainChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Keuangan'],
            datasets: [{
                label: 'Pemasukan',
                data: [<?= $data['total_masuk']; ?>],
                backgroundColor: '#4f46e5',
                borderRadius: 12,
                barThickness: 60
            }, {
                label: 'Pengeluaran',
                data: [<?= $data['total_keluar']; ?>],
                backgroundColor: '#10b981',
                borderRadius: 12,
                barThickness: 60
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false }, ticks: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });

    // Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Masuk', 'Keluar'],
            datasets: [{
                data: [<?= $data['total_masuk']; ?>, <?= $data['total_keluar']; ?>],
                backgroundColor: ['#4f46e5', '#10b981'],
                borderWidth: 0,
                cutout: '80%'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>

<?php require_once '../app/views/templates/footer.php'; ?>

