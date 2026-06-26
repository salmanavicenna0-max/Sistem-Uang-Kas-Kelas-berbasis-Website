<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h3 class="text-2xl font-bold text-slate-800">Jurnal Transaksi</h3>
        <p class="text-slate-500">Catatan riwayat keuangan masuk dan keluar secara transparan.</p>
    </div>
    <div class="flex flex-wrap gap-3">
        <a href="<?= BASEURL; ?>/transaksi/export?start_date=<?= $data['start_date'] ?>&end_date=<?= $data['end_date'] ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-2xl font-bold transition-all flex items-center gap-2 shadow-lg shadow-emerald-200">
            
            <span>Export Excel</span>
        </a>
        <?php if($_SESSION['user']['role'] == 'admin' || $_SESSION['user']['role'] == 'bendahara') : ?>
        <button onclick="toggleModal('modal-transaksi')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-2xl font-bold transition-all flex items-center gap-2 shadow-lg">
            
            <span>Catat Transaksi</span>
        </button>
        <?php endif; ?>
    </div>
</div>

<?php Flasher::flash(); ?>

<!-- Filter & Summary Row -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl border col-span-1 lg:col-span-4 flex flex-col md:flex-row gap-4 justify-between items-center">
        <form action="<?= BASEURL; ?>/transaksi" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <div class="flex items-center gap-2 bg-slate-50 border p-2 rounded-xl">
                
                <input type="date" name="start_date" value="<?= $data['start_date'] ?>" class="bg-transparent border-none text-sm outline-none focus:ring-0">
            </div>
            <span class="text-slate-400 font-medium">-</span>
            <div class="flex items-center gap-2 bg-slate-50 border p-2 rounded-xl">
                
                <input type="date" name="end_date" value="<?= $data['end_date'] ?>" class="bg-transparent border-none text-sm outline-none focus:ring-0">
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-indigo-700 transition-colors">Filter</button>
            <?php if($data['start_date'] || $data['end_date']): ?>
                <a href="<?= BASEURL; ?>/transaksi" class="text-slate-400 hover:text-red-500 font-medium text-sm ml-2">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="bg-white p-6 rounded-3xl border flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-xl">
            
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Masuk</p>
            <p class="text-xl font-bold text-slate-800">Rp <?= number_format($data['total_masuk'], 0, ',', '.'); ?></p>
        </div>
    </div>
    <div class="bg-white p-6 rounded-3xl border flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl">
            
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Keluar</p>
            <p class="text-xl font-bold text-slate-800">Rp <?= number_format($data['total_keluar'], 0, ',', '.'); ?></p>
        </div>
    </div>
    <div class="bg-indigo-600 p-6 rounded-3xl flex items-center gap-4 text-white shadow-lg shadow-indigo-100 lg:col-span-2">
        <div class="w-12 h-12 rounded-2xl bg-teal-500 flex items-center justify-center text-xl">
            
        </div>
        <div>
            <p class="text-xs font-bold text-teal-200 uppercase tracking-widest">Saldo Akhir</p>
            <p class="text-xl font-bold">Rp <?= number_format($data['saldo'], 0, ',', '.'); ?></p>
        </div>
    </div>
</div>

<!-- Transaction Table -->
<div class="bg-white rounded-3xl shadow-sm border overflow-hidden mb-6">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Keterangan</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Oleh</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Nominal</th>
                    <?php if($_SESSION['user']['role'] == 'admin') : ?>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="divide-y text-slate-700">
                <?php foreach($data['transaksi'] as $t) : ?>
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-6 py-4">
                        <p class="text-sm font-bold text-slate-700"><?= date('d M Y', strtotime($t['tanggal'])); ?></p>
                    </td>
                    <td class="px-6 py-4 max-w-xs">
                        <!-- XSS Prevention: htmlspecialchars already done on insert, but we can double check -->
                        <p class="text-sm text-slate-600 italic truncate" title="<?= htmlspecialchars($t['keterangan'], ENT_QUOTES, 'UTF-8'); ?>">
                            "<?= htmlspecialchars($t['keterangan'], ENT_QUOTES, 'UTF-8'); ?>"
                        </p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-600 uppercase">
                            <?= htmlspecialchars($t['nama_kategori'], ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-medium text-slate-600"><?= htmlspecialchars($t['nama_user'], ENT_QUOTES, 'UTF-8'); ?></span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <span class="text-sm font-bold <?= $t['tipe'] == 'masuk' ? 'text-emerald-600' : 'text-rose-600' ?>">
                            <?= $t['tipe'] == 'masuk' ? '+' : '-' ?> Rp <?= number_format($t['jumlah'], 0, ',', '.'); ?>
                        </span>
                    </td>
                    <?php if($_SESSION['user']['role'] == 'admin') : ?>
                    <td class="px-6 py-4 text-right">
                        <a href="<?= BASEURL; ?>/transaksi/hapus/<?= $t['id']; ?>" class="text-xs font-bold text-red-500 hover:text-red-700 hover:underline transition-colors px-2 py-1" onclick="return confirm('Hapus transaksi ini? (Tetap tercatat di log)')">
                            Hapus
                        </a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($data['transaksi'])): ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                        
                        <p>Belum ada data transaksi.</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<?php if($data['total_pages'] > 1): ?>
<div class="flex justify-center mb-8">
    <div class="flex items-center gap-1 bg-white p-1 rounded-xl shadow-sm border border-slate-100">
        <?php 
        $query_params = [];
        if ($data['start_date']) $query_params['start_date'] = $data['start_date'];
        if ($data['end_date']) $query_params['end_date'] = $data['end_date'];
        $base_url = BASEURL . '/transaksi';
        
        $prev_params = $query_params;
        $prev_params['page'] = max(1, $data['page'] - 1);
        $prev_url = $base_url . '?' . http_build_query($prev_params);
        ?>
        <a href="<?= $prev_url ?>" class="px-3 py-2 rounded-lg text-sm font-medium <?= $data['page'] == 1 ? 'text-slate-300 pointer-events-none' : 'text-slate-600 hover:bg-slate-50' ?>">
            
        </a>
        
        <?php for($i=1; $i<=$data['total_pages']; $i++): 
            $page_params = $query_params;
            $page_params['page'] = $i;
            $page_url = $base_url . '?' . http_build_query($page_params);
        ?>
            <a href="<?= $page_url ?>" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors <?= $data['page'] == $i ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-600 hover:bg-slate-50' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
        
        <?php 
        $next_params = $query_params;
        $next_params['page'] = min($data['total_pages'], $data['page'] + 1);
        $next_url = $base_url . '?' . http_build_query($next_params);
        ?>
        <a href="<?= $next_url ?>" class="px-3 py-2 rounded-lg text-sm font-medium <?= $data['page'] == $data['total_pages'] ? 'text-slate-300 pointer-events-none' : 'text-slate-600 hover:bg-slate-50' ?>">
            
        </a>
    </div>
</div>
<?php endif; ?>

<!-- Modal Tambah Transaksi -->
<div id="modal-transaksi" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-indigo-600 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?= BASEURL; ?>/transaksi/tambah" method="post">
                <div class="bg-white px-8 pt-8 pb-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Catat Transaksi Baru</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tipe</label>
                                <select name="tipe" required class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                                    <option value="masuk">Pemasukan (+)</option>
                                    <option value="keluar">Pengeluaran (-)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal</label>
                                <input type="date" name="tanggal" value="<?= date('Y-m-d'); ?>" required class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                            <select name="kategori_id" required class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                                <?php foreach($data['kategori'] as $k) : ?>
                                <option value="<?= htmlspecialchars($k['id'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($k['nama'], ENT_QUOTES, 'UTF-8'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nominal (Rp)</label>
                            <input type="number" name="jumlah" required placeholder="Contoh: 50000" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Keterangan</label>
                            <textarea name="keterangan" required placeholder="Keterangan transaksi..." class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm h-24"></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-8 py-6 flex flex-row-reverse gap-3">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all text-sm">Simpan Jurnal</button>
                    <button type="button" onclick="toggleModal('modal-transaksi')" class="bg-white border text-slate-600 px-6 py-2.5 rounded-xl font-bold transition-all text-sm">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleModal(id) {
    const modal = document.getElementById(id);
    modal.classList.toggle('hidden');
}
</script>

