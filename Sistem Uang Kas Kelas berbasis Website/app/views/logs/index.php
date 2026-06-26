<?php require_once '../app/views/templates/header.php'; ?>

<div class="mb-8">
    <h3 class="text-2xl font-bold text-slate-800">Log Transaksi (Audit Trail)</h3>
    <p class="text-slate-500">Rekam jejak seluruh perubahan data transaksi secara mendetail.</p>
</div>

<div class="bg-white rounded-3xl shadow-sm border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Oleh</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ID Transaksi</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Detail Data</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php foreach($data['logs'] as $log) : ?>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-bold text-slate-700"><?= date('d M Y', strtotime($log['created_at'])); ?></span>
                        <span class="text-xs text-slate-400 block"><?= date('H:i:s', strtotime($log['created_at'])); ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-sm font-medium text-slate-700"><?= $log['nama_user']; ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                            <?= $log['aksi'] == 'delete' ? 'bg-red-50 text-red-500' : ($log['aksi'] == 'insert' ? 'bg-emerald-50 text-emerald-500' : 'bg-teal-50 text-teal-500') ?>">
                            <?= $log['aksi']; ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">
                        #<?= $log['transaksi_id']; ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-[10px] bg-slate-50 p-2 rounded-lg font-mono text-slate-500 max-w-xs overflow-hidden truncate">
                            <?= $log['aksi'] == 'insert' ? $log['data_baru'] : $log['data_lama']; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../app/views/templates/footer.php'; ?>

