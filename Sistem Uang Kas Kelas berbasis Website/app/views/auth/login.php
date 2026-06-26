<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UangKas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center bg-indigo-600 w-16 h-16 rounded-3xl shadow-xl shadow-indigo-200 mb-6 text-white text-3xl">
                
            </div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Selamat Datang Kembali</h1>
            <p class="text-slate-500 mt-2">Masuk ke dashboard UangKas Kelas Anda</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border p-10">
            <?php Flasher::flash(); ?>
            
            <form action="<?= BASEURL; ?>/auth/login" method="post" class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                    <div class="relative">
                        
                        <input type="email" name="email" required placeholder="Masukkan email" 
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                    <div class="relative">
                        
                        <input type="password" name="password" required placeholder="••••••••" 
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all text-sm">
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-slate-500 group-hover:text-slate-700 transition-colors">Ingat Saya</span>
                    </label>
                    <a href="#" class="text-indigo-600 font-bold hover:underline">Lupa Password?</a>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-slate-200">
                    Masuk Sekarang
                </button>
            </form>
        </div>

        <p class="text-center text-slate-500 mt-8 text-sm">
            Belum punya akun? <a href="#" class="text-indigo-600 font-bold hover:underline">Hubungi Wali Kelas</a>
        </p>
    </div>
</body>
</html>

