<div class="glass-card rounded-2xl p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Uang Kas Mingguan</h3>
            <p class="text-slate-500 text-sm mt-1">Checklist pembayaran uang kas Rp 2.000 / minggu</p>
        </div>
        
        <!-- Filter Form -->
        <form action="<?= BASEURL; ?>/kas" method="GET" class="flex gap-4">
            <select name="bulan" class="p-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all" onchange="this.form.submit()">
                <?php 
                $bulan_nama = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                for($i=1; $i<=12; $i++): 
                ?>
                <option value="<?= $i ?>" <?= $data['bulan'] == $i ? 'selected' : '' ?>><?= $bulan_nama[$i] ?></option>
                <?php endfor; ?>
            </select>
            <select name="tahun" class="p-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all" onchange="this.form.submit()">
                <?php for($i=2024; $i<=date('Y')+1; $i++): ?>
                <option value="<?= $i ?>" <?= $data['tahun'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
        </form>
    </div>

    <div class="w-full mb-4">
        <?php Flasher::flash(); ?>
    </div>

    <div class="overflow-x-auto bg-white rounded-xl border border-slate-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-600 text-sm border-b border-slate-100">
                    <th class="p-4 font-semibold w-12 text-center">No</th>
                    <th class="p-4 font-semibold">Nama Siswa</th>
                    <th class="p-4 font-semibold text-center w-32 border-l border-slate-100">Minggu 1</th>
                    <th class="p-4 font-semibold text-center w-32 border-l border-slate-100">Minggu 2</th>
                    <th class="p-4 font-semibold text-center w-32 border-l border-slate-100">Minggu 3</th>
                    <th class="p-4 font-semibold text-center w-32 border-l border-slate-100">Minggu 4</th>
                </tr>
            </thead>
            <tbody class="text-slate-700 divide-y divide-slate-100">
                <?php $no = 1; foreach ($data['kas'] as $k) : ?>
                <tr id="row-<?= $k['id']; ?>" class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-4 text-center text-sm font-medium text-slate-500"><?= $no++; ?></td>
                    <td class="p-4">
                        <div class="font-bold text-slate-800"><?= $k['nama']; ?></div>
                        <div class="text-xs font-medium text-slate-500 mt-0.5"><?= $k['nis']; ?></div>
                    </td>
                    <?php for($m=1; $m<=4; $m++): ?>
                        <td class="p-3 text-center border-l border-slate-100 align-middle">
                            <?php if($k['minggu_'.$m] == 'lunas'): ?>
                                <form action="<?= BASEURL; ?>/kas/batal" method="POST" class="m-0">
                                    <input type="hidden" name="murid_id" value="<?= $k['id']; ?>">
                                    <input type="hidden" name="minggu_ke" value="<?= $m; ?>">
                                    <input type="hidden" name="bulan" value="<?= $data['bulan']; ?>">
                                    <input type="hidden" name="tahun" value="<?= $data['tahun']; ?>">
                                    <button type="submit" class="bg-emerald-50 text-emerald-600 hover:bg-red-50 hover:text-red-500 border border-emerald-200 hover:border-red-200 px-2 py-2 rounded-xl text-xs font-bold transition-all w-full flex flex-col items-center justify-center gap-1 group shadow-sm">
                                        
                                        
                                        <span class="group-hover:hidden">Lunas</span>
                                        <span class="hidden group-hover:block">Batal</span>
                                    </button>
                                </form>
                            <?php else: ?>
                                <form action="<?= BASEURL; ?>/kas/bayar" method="POST" class="m-0">
                                    <input type="hidden" name="murid_id" value="<?= $k['id']; ?>">
                                    <input type="hidden" name="minggu_ke" value="<?= $m; ?>">
                                    <input type="hidden" name="bulan" value="<?= $data['bulan']; ?>">
                                    <input type="hidden" name="tahun" value="<?= $data['tahun']; ?>">
                                    <button type="submit" class="bg-white text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 hover:border-indigo-200 px-2 py-2 rounded-xl text-xs font-bold transition-all w-full flex flex-col items-center justify-center gap-1 shadow-sm">
                                        
                                        <span>Belum</span>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    <?php endfor; ?>
                </tr>
                <?php endforeach; ?>
                
                <?php if(empty($data['kas'])): ?>
                <tr>
                    <td colspan="6" class="p-8 text-center text-slate-500">
                        
                        <p>Belum ada data murid.</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

