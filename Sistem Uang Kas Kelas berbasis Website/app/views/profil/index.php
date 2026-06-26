<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
    <div>
        <h3 class="text-2xl font-bold text-slate-800">Profil Saya</h3>
        <p class="text-slate-500">Kelola informasi pribadi dan pengaturan keamanan akun Anda.</p>
    </div>
</div>

<?php Flasher::flash(); ?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    
    <!-- Profil Card -->
    <div class="bg-white p-8 rounded-3xl shadow-sm border text-center h-fit">
        <div class="w-32 h-32 mx-auto rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-5xl font-bold mb-6 shadow-inner">
            <?= substr(htmlspecialchars($data['user']['nama'], ENT_QUOTES, 'UTF-8'), 0, 1); ?>
        </div>
        <h4 class="text-2xl font-bold text-slate-800 mb-1"><?= htmlspecialchars($data['user']['nama'], ENT_QUOTES, 'UTF-8'); ?></h4>
        <p class="text-sm font-medium text-slate-500 mb-4"><?= htmlspecialchars($data['user']['email'], ENT_QUOTES, 'UTF-8'); ?></p>
        <div class="inline-block px-4 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600 uppercase tracking-widest">
            <?= htmlspecialchars($data['user']['role'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
    </div>
    
    <!-- Edit Forms -->
    <div class="md:col-span-2 space-y-8">
        
        <!-- Form Informasi Pribadi -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border">
            <h4 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                 Informasi Pribadi
            </h4>
            <form action="<?= BASEURL; ?>/profil/update" method="POST">
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" value="<?= htmlspecialchars($data['user']['nama'], ENT_QUOTES, 'UTF-8'); ?>" required class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email (Tidak dapat diubah)</label>
                        <input type="email" value="<?= htmlspecialchars($data['user']['email'], ENT_QUOTES, 'UTF-8'); ?>" disabled class="w-full px-4 py-3 bg-slate-100 border-none rounded-2xl text-slate-500 cursor-not-allowed text-sm">
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold transition-all w-full md:w-auto shadow-lg shadow-indigo-100">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Form Ganti Password -->
        <div class="bg-white p-8 rounded-3xl shadow-sm border">
            <h4 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                 Ganti Password
            </h4>
            <form action="<?= BASEURL; ?>/profil/ganti_password" method="POST">
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Password Saat Ini</label>
                        <input type="password" name="password_lama" required class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Password Baru</label>
                            <input type="password" name="password_baru" required class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="konfirmasi_password" required class="w-full px-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                        </div>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold transition-all w-full md:w-auto shadow-lg">
                            Perbarui Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</div>

