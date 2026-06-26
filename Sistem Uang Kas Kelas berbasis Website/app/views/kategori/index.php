<?php require_once '../app/views/templates/header.php'; ?>

<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-2xl font-bold text-slate-800">Kategori Transaksi</h3>
        <p class="text-slate-500">Kelola pengelompokan dana (Kas, Denda, Patungan, dll).</p>
    </div>
    <?php if($_SESSION['user']['role'] == 'admin') : ?>
    <button onclick="toggleModal('modal-kategori')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold transition-all flex items-center gap-2 shadow-lg shadow-indigo-100">
        
        <span>Tambah Kategori</span>
    </button>
    <?php endif; ?>
</div>

<?php Flasher::flash(); ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach($data['kategori'] as $k) : ?>
    <div class="bg-white p-6 rounded-3xl border shadow-sm hover:shadow-md transition-shadow group relative overflow-hidden">
        <div class="relative z-10">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                
            </div>
            <h4 class="font-bold text-slate-800 text-lg"><?= $k['nama']; ?></h4>
            <p class="text-sm text-slate-500 mt-2"><?= $k['deskripsi'] ?: 'Tidak ada deskripsi.'; ?></p>
            
            <?php if($_SESSION['user']['role'] == 'admin') : ?>
            <div class="mt-6 pt-6 border-t flex items-center justify-between">
                <div class="flex gap-2">
                    <a href="<?= BASEURL; ?>/kategori/hapus/<?= $k['id']; ?>" class="text-slate-400 hover:text-red-600 text-sm font-bold" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                </div>
                <span class="text-[10px] text-slate-300 font-bold uppercase">ID: #<?= $k['id']; ?></span>
            </div>
            <?php endif; ?>
        </div>
        
    </div>
    <?php endforeach; ?>
</div>

<!-- Modal Tambah Kategori -->
<div id="modal-kategori" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-indigo-600 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="<?= BASEURL; ?>/kategori/tambah" method="post">
                <div class="bg-white px-8 pt-8 pb-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-6">Tambah Kategori Baru</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori</label>
                            <input type="text" name="nama" required placeholder="Contoh: Uang Kas, Denda, dll" class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" placeholder="Keterangan singkat kategori ini..." class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm h-24"></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-8 py-6 flex flex-row-reverse gap-3">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold transition-all text-sm">Simpan Kategori</button>
                    <button type="button" onclick="toggleModal('modal-kategori')" class="bg-white border text-slate-600 px-6 py-2.5 rounded-xl font-bold transition-all text-sm">Batal</button>
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

<?php require_once '../app/views/templates/footer.php'; ?>

