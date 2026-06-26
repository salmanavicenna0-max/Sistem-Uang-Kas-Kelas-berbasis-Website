<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h3 class="text-2xl font-bold text-slate-800">Manajemen Murid</h3>
        <p class="text-slate-500">Kelola data siswa dan riwayat iuran mereka.</p>
    </div>
    <?php if($_SESSION['user']['role'] == 'admin') : ?>
    <button onclick="toggleModal('modal-murid')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold transition-all flex items-center gap-2 shadow-lg shadow-indigo-100">
        
        <span>Tambah Murid</span>
    </button>
    <?php endif; ?>
</div>

<?php Flasher::flash(); ?>

<!-- Table Section -->
<div class="bg-white rounded-3xl shadow-sm border overflow-hidden mb-6">
    <div class="p-6 border-b flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form action="<?= BASEURL; ?>/murid" method="GET" class="relative flex-1 max-w-md flex gap-2">
            <div class="relative flex-1">
                
                <input type="text" name="keyword" value="<?= htmlspecialchars($data['keyword'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Cari nama atau NIS..." class="w-full pl-12 pr-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm outline-none">
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-2xl font-bold transition-all text-sm">Cari</button>
            <?php if(!empty($data['keyword'])): ?>
                <a href="<?= BASEURL; ?>/murid" class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-3 rounded-2xl font-bold transition-all text-sm flex items-center"></a>
            <?php endif; ?>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Murid</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">NIS</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">No. Telp</th>
                    <?php if($_SESSION['user']['role'] == 'admin') : ?>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="divide-y text-slate-700">
                <?php foreach($data['murid'] as $m) : ?>
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                                <?= substr(htmlspecialchars($m['nama'], ENT_QUOTES, 'UTF-8'), 0, 1); ?>
                            </div>
                            <div>
                                <span class="font-bold text-slate-800 block"><?= htmlspecialchars($m['nama'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="text-[10px] font-medium text-slate-400"><?= htmlspecialchars($m['alamat'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-slate-600"><?= htmlspecialchars($m['nis'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 uppercase">
                            <?= htmlspecialchars($m['kelas'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-slate-500"><?= htmlspecialchars($m['no_telp'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <?php if($_SESSION['user']['role'] == 'admin') : ?>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="<?= BASEURL; ?>/murid/hapus/<?= $m['id']; ?>" class="text-xs font-bold text-red-500 hover:text-red-700 hover:underline transition-colors px-2 py-1" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                Hapus
                            </a>
                        </div>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($data['murid'])): ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        
                        <p>Tidak ada data murid yang ditemukan.</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<?php if(isset($data['total_pages']) && $data['total_pages'] > 1): ?>
<div class="flex justify-center mb-8">
    <div class="flex items-center gap-1 bg-white p-1 rounded-xl shadow-sm border border-slate-100">
        <?php 
        $query_params = [];
        if ($data['keyword']) $query_params['keyword'] = $data['keyword'];
        $base_url = BASEURL . '/murid';
        
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

<!-- Modal Tambah Murid -->
<div id="modal-murid" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-indigo-600 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?= BASEURL; ?>/murid/tambah" method="post">
                <div class="bg-white px-8 pt-8 pb-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Tambah Murid Baru</h3>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama" required class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">NIS</label>
                                <input type="text" name="nis" required class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Kelas</label>
                            <input type="text" name="kelas" required class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">No. Telepon</label>
                            <input type="text" name="no_telp" required class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Alamat</label>
                            <textarea name="alamat" required class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm h-24"></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-8 py-6 flex flex-row-reverse gap-3">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all text-sm">Simpan Data</button>
                    <button type="button" onclick="toggleModal('modal-murid')" class="bg-white border text-slate-600 px-6 py-2.5 rounded-xl font-bold transition-all text-sm">Batal</button>
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

