<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi — Moma</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#2563EB' },
                    fontFamily: { poppins: ['Poppins', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        h2 { scroll-margin-top: 80px; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur border-b border-gray-100">
        <div class="max-w-4xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-900">Moma</span>
            </a>
            <a href="/" class="text-sm text-primary font-medium hover:underline">← Kembali ke Beranda</a>
        </div>
    </nav>

    <!-- Content -->
    <main class="pt-24 pb-20 px-6">
        <div class="max-w-3xl mx-auto">

            <!-- Header -->
            <div class="mb-10">
                <div class="inline-flex items-center gap-2 bg-blue-50 text-primary text-xs font-medium px-3 py-1 rounded-full mb-4">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Dokumen Resmi
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-3">Kebijakan Privasi</h1>
                <p class="text-gray-500 text-sm">Berlaku sejak: <strong>1 Januari 2025</strong> &nbsp;·&nbsp; Diperbarui: <strong>{{ date('d F Y') }}</strong></p>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Selamat datang di <strong>Moma</strong> — aplikasi pencatat keuangan pribadi berbasis AI. Moma dirancang dengan prinsip <strong>privasi-utama (privacy-first)</strong>: seluruh data keuangan Anda disimpan secara lokal di perangkat Anda sendiri. Kami berkomitmen transparan tentang data apa yang meninggalkan perangkat Anda dan kapan.
                </p>
            </div>

            <!-- Table of Contents -->
            <div class="bg-blue-50 rounded-2xl p-6 mb-10 border border-blue-100">
                <h2 class="font-semibold text-gray-900 mb-3 text-sm uppercase tracking-wide">Daftar Isi</h2>
                <ol class="space-y-1 text-sm text-primary">
                    <li><a href="#informasi" class="hover:underline">1. Informasi yang Kami Kumpulkan</a></li>
                    <li><a href="#penggunaan" class="hover:underline">2. Cara Kami Menggunakan Informasi</a></li>
                    <li><a href="#penyimpanan" class="hover:underline">3. Penyimpanan dan Keamanan Data</a></li>
                    <li><a href="#berbagi" class="hover:underline">4. Pembagian Data kepada Pihak Ketiga</a></li>
                    <li><a href="#hak" class="hover:underline">5. Hak-Hak Anda</a></li>
                    <li><a href="#anak" class="hover:underline">6. Privasi Anak-Anak</a></li>
                    <li><a href="#perubahan" class="hover:underline">7. Perubahan Kebijakan</a></li>
                    <li><a href="#kontak" class="hover:underline">8. Hubungi Kami</a></li>
                </ol>
            </div>

            <!-- Sections -->
            <div class="space-y-10">

                <!-- 1 -->
                <section id="informasi">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold">1</span>
                        Informasi yang Kami Kumpulkan
                    </h2>
                    <div class="space-y-4 text-gray-600 leading-relaxed">
                        <div class="bg-white rounded-xl p-5 border border-gray-200">
                            <h3 class="font-medium text-gray-800 mb-2">a. Informasi Akun</h3>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Nama lengkap dan alamat email (dari Google Sign-In)</li>
                                <li>Foto profil (dari akun Google, jika tersedia)</li>
                                <li>ID pengguna unik yang dibuat sistem</li>
                            </ul>
                        </div>
                        <div class="bg-white rounded-xl p-5 border border-green-200">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="font-medium text-gray-800">b. Data Keuangan</h3>
                                <span class="text-xs bg-green-100 text-green-700 font-medium px-2 py-0.5 rounded-full">Tersimpan Lokal</span>
                            </div>
                            <ul class="list-disc list-inside space-y-1 text-sm text-gray-600">
                                <li>Catatan transaksi (pemasukan, pengeluaran, tanggal, kategori, catatan)</li>
                                <li>Data anggaran (budget) dan aset yang Anda buat</li>
                                <li>Foto struk/bukti transaksi yang Anda ambil</li>
                            </ul>
                            <p class="mt-3 text-xs text-green-700 bg-green-50 px-3 py-2 rounded-lg">
                                <strong>Data ini disimpan sepenuhnya di perangkat Anda</strong> dan tidak dikirim ke server kami kecuali Anda secara eksplisit memilih fitur <em>Backup Online</em>. Tanpa backup online, server kami tidak pernah menerima data transaksi Anda.
                            </p>
                        </div>
                        <div class="bg-white rounded-xl p-5 border border-gray-200">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="font-medium text-gray-800">c. Pesan ke Asisten AI</h3>
                                <span class="text-xs bg-amber-100 text-amber-700 font-medium px-2 py-0.5 rounded-full">Dikirim ke API</span>
                            </div>
                            <ul class="list-disc list-inside space-y-1 text-sm text-gray-600">
                                <li>Teks pesan yang Anda kirim ke asisten AI Moma</li>
                                <li>Ringkasan konteks keuangan yang relevan (untuk menghasilkan jawaban yang akurat)</li>
                            </ul>
                            <p class="mt-3 text-xs text-amber-700 bg-amber-50 px-3 py-2 rounded-lg">
                                Pesan AI diproses oleh Google Gemini API hanya untuk sesi tersebut dan tidak disimpan secara permanen di server kami.
                            </p>
                        </div>
                        <div class="bg-white rounded-xl p-5 border border-gray-200">
                            <h3 class="font-medium text-gray-800 mb-2">d. Izin Perangkat yang Digunakan</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm mt-2">
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-primary mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span><strong>Kamera / Galeri</strong> — untuk foto struk transaksi</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-primary mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span><strong>Mikrofon</strong> — untuk fitur catat via suara (speech-to-text)</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-primary mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span><strong>Biometrik</strong> — untuk kunci aplikasi (sidik jari / Face ID). Data biometrik tidak pernah meninggalkan perangkat Anda.</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-primary mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span><strong>Penyimpanan</strong> — untuk ekspor/impor backup data lokal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 2 -->
                <section id="penggunaan">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold">2</span>
                        Cara Kami Menggunakan Informasi
                    </h2>
                    <div class="mb-4 bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-800">
                        <strong>Prinsip utama:</strong> data keuangan Anda diproses sepenuhnya di perangkat Anda. Server kami hanya menerima data yang Anda kirim secara eksplisit.
                    </div>
                    <ul class="space-y-3 text-gray-600 text-sm leading-relaxed">
                        <li class="flex items-start gap-3 bg-white rounded-xl p-4 border border-gray-200">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span><strong>Layanan lokal:</strong> mencatat transaksi, mengelola budget &amp; aset, serta menampilkan laporan dan grafik — semua berjalan di perangkat Anda tanpa koneksi internet.</span>
                        </li>
                        <li class="flex items-start gap-3 bg-white rounded-xl p-4 border border-gray-200">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span><strong>Asisten AI (opsional):</strong> ketika Anda menggunakan fitur chat AI, pesan dan ringkasan konteks keuangan dikirim ke Google Gemini API hanya untuk memproses jawaban, lalu sesi tersebut berakhir.</span>
                        </li>
                        <li class="flex items-start gap-3 bg-white rounded-xl p-4 border border-gray-200">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span><strong>Backup online (opsional, atas permintaan Anda):</strong> hanya ketika Anda menekan tombol <em>Backup Online</em>, data transaksi, budget, dan aset dikirim ke server kami untuk disimpan sebagai cadangan. Anda yang mengendalikan kapan ini terjadi.</span>
                        </li>
                        <li class="flex items-start gap-3 bg-white rounded-xl p-4 border border-gray-200">
                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span><strong>Autentikasi akun:</strong> informasi dasar dari Google Sign-In (nama, email, foto profil) digunakan hanya untuk mengidentifikasi akun Anda dan mengasosiasikan data backup jika Anda mengaktifkannya.</span>
                        </li>
                    </ul>
                </section>

                <!-- 3 -->
                <section id="penyimpanan">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold">3</span>
                        Penyimpanan dan Keamanan Data
                    </h2>
                    <div class="space-y-4 text-gray-600 text-sm leading-relaxed">

                        <!-- Diagram alur -->
                        <div class="bg-white rounded-xl p-5 border border-gray-200">
                            <h3 class="font-medium text-gray-800 mb-4">Di mana data Anda berada?</h3>
                            <div class="space-y-3">
                                <!-- Lokal -->
                                <div class="flex items-start gap-3 p-3 bg-green-50 rounded-lg border border-green-200">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-green-800">Perangkat Anda (Default)</p>
                                        <p class="text-green-700 mt-0.5">Semua transaksi, budget, aset, foto struk, PIN, dan pengaturan keamanan. Data ini <strong>tidak pernah meninggalkan perangkat</strong> kecuali Anda memilih backup online.</p>
                                    </div>
                                </div>
                                <!-- Server opsional -->
                                <div class="flex items-start gap-3 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-blue-800">Server Kami <span class="font-normal text-blue-600 text-xs">(hanya jika Anda klik Backup Online)</span></p>
                                        <p class="text-blue-700 mt-0.5">Data backup Anda disimpan terenkripsi menggunakan HTTPS/TLS. Akses terbatas dan hanya digunakan untuk mengembalikan data ke perangkat Anda.</p>
                                    </div>
                                </div>
                                <!-- Google API -->
                                <div class="flex items-start gap-3 p-3 bg-amber-50 rounded-lg border border-amber-200">
                                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-amber-800">Google Gemini API <span class="font-normal text-amber-600 text-xs">(hanya saat pakai fitur AI)</span></p>
                                        <p class="text-amber-700 mt-0.5">Pesan chat diproses untuk menghasilkan respons AI. Data tidak disimpan secara permanen setelah sesi selesai.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Keamanan lokal -->
                        <div class="bg-white rounded-xl p-5 border border-gray-200">
                            <h3 class="font-medium text-gray-800 mb-2">Keamanan Data Lokal</h3>
                            <ul class="list-disc list-inside space-y-1 text-gray-600">
                                <li>PIN disimpan sebagai hash SHA-256 — tidak dapat dikembalikan ke teks asli</li>
                                <li>Data biometrik (sidik jari / Face ID) sepenuhnya dikelola oleh sistem operasi perangkat dan tidak pernah keluar dari perangkat</li>
                                <li>Database lokal hanya dapat diakses oleh aplikasi Moma</li>
                            </ul>
                        </div>

                        <!-- Retensi -->
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                            <p class="text-amber-800">
                                <strong>Retensi Data Server:</strong> Jika Anda pernah melakukan backup online, data tersebut disimpan di server selama akun aktif. Setelah penghapusan akun, semua data backup dihapus permanen dari server dalam waktu maksimal <strong>30 hari</strong>. Jika Anda tidak pernah backup online, server kami tidak menyimpan data keuangan Anda sama sekali.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- 4 -->
                <section id="berbagi">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold">4</span>
                        Pembagian Data kepada Pihak Ketiga
                    </h2>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">Kami <strong>tidak menjual</strong> data Anda. Data Anda hanya dibagikan dalam kondisi berikut:</p>
                    <div class="space-y-3 text-sm">
                        <div class="bg-white rounded-xl p-5 border border-gray-200">
                            <h3 class="font-medium text-gray-800 mb-2">Google (Sign-In &amp; AI)</h3>
                            <p class="text-gray-600">Kami menggunakan Google Sign-In untuk autentikasi dan Google Gemini AI untuk fitur asisten keuangan. Interaksi Anda tunduk pada <a href="https://policies.google.com/privacy" class="text-primary hover:underline" target="_blank">Kebijakan Privasi Google</a>. Data transaksi yang dikirim ke AI digunakan hanya untuk menghasilkan respons dalam sesi tersebut.</p>
                        </div>
                        <div class="bg-white rounded-xl p-5 border border-gray-200">
                            <h3 class="font-medium text-gray-800 mb-2">Kewajiban Hukum</h3>
                            <p class="text-gray-600">Kami dapat mengungkapkan data jika diwajibkan oleh hukum, peraturan pemerintah, atau perintah pengadilan yang sah di wilayah hukum Republik Indonesia.</p>
                        </div>
                        <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                            <p class="text-green-800 text-sm"><strong>Tidak ada pihak lain.</strong> Kami tidak menggunakan jaringan iklan, tidak menjual data ke perusahaan analitik pihak ketiga, dan tidak membagikan data tanpa persetujuan eksplisit Anda.</p>
                        </div>
                    </div>
                </section>

                <!-- 5 -->
                <section id="hak">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold">5</span>
                        Hak-Hak Anda
                    </h2>
                    <p class="text-gray-600 text-sm mb-4">Sebagai pengguna Moma, Anda memiliki hak berikut atas data pribadi Anda:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div class="bg-white rounded-xl p-4 border border-gray-200 flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <div><strong class="text-gray-800">Akses Data</strong><p class="text-gray-500 mt-1">Lihat semua data yang Anda miliki langsung di aplikasi.</p></div>
                        </div>
                        <div class="bg-white rounded-xl p-4 border border-gray-200 flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <div><strong class="text-gray-800">Ekspor Data</strong><p class="text-gray-500 mt-1">Unduh semua transaksi Anda dalam format CSV atau JSON kapan saja.</p></div>
                        </div>
                        <div class="bg-white rounded-xl p-4 border border-gray-200 flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            <div><strong class="text-gray-800">Perbaiki Data</strong><p class="text-gray-500 mt-1">Edit atau hapus transaksi yang salah langsung di aplikasi.</p></div>
                        </div>
                        <div class="bg-white rounded-xl p-4 border border-gray-200 flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <div><strong class="text-gray-800">Hapus Akun</strong><p class="text-gray-500 mt-1">Hapus akun dan seluruh data Anda secara permanen melalui menu Pengaturan → Hapus Akun, atau hubungi kami.</p></div>
                        </div>
                    </div>
                </section>

                <!-- 6 -->
                <section id="anak">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold">6</span>
                        Privasi Anak-Anak
                    </h2>
                    <div class="bg-white rounded-xl p-5 border border-gray-200 text-gray-600 text-sm leading-relaxed">
                        <p>Aplikasi Moma <strong>tidak ditujukan untuk anak-anak di bawah usia 13 tahun</strong>. Kami tidak secara sengaja mengumpulkan informasi pribadi dari anak-anak. Jika Anda percaya bahwa anak di bawah umur telah memberikan data pribadi kepada kami, silakan hubungi kami segera dan kami akan menghapus informasi tersebut.</p>
                    </div>
                </section>

                <!-- 7 -->
                <section id="perubahan">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold">7</span>
                        Perubahan Kebijakan
                    </h2>
                    <div class="bg-white rounded-xl p-5 border border-gray-200 text-gray-600 text-sm leading-relaxed">
                        <p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Setiap perubahan signifikan akan diberitahukan melalui notifikasi dalam aplikasi atau email ke alamat terdaftar Anda, minimal <strong>7 hari sebelum</strong> perubahan berlaku. Penggunaan berkelanjutan atas aplikasi setelah tanggal efektif dianggap sebagai penerimaan atas perubahan tersebut.</p>
                    </div>
                </section>

                <!-- 8 -->
                <section id="kontak">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 bg-primary text-white rounded-full flex items-center justify-center text-xs font-bold">8</span>
                        Hubungi Kami
                    </h2>
                    <div class="bg-gradient-to-br from-primary to-blue-700 rounded-2xl p-6 text-white">
                        <p class="text-blue-100 text-sm mb-4">Jika Anda memiliki pertanyaan, kekhawatiran, atau permintaan terkait privasi data Anda, jangan ragu untuk menghubungi kami:</p>
                        <div class="space-y-3">
                            <a href="mailto:pianpermana1207@gmail.com" class="flex items-center gap-3 bg-white/10 hover:bg-white/20 transition rounded-xl px-4 py-3">
                                <svg class="w-5 h-5 text-blue-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <div>
                                    <p class="text-xs text-blue-200">Email</p>
                                    <p class="font-medium">pianpermana1207@gmail.com</p>
                                </div>
                            </a>
                            <div class="flex items-center gap-3 bg-white/10 rounded-xl px-4 py-3">
                                <svg class="w-5 h-5 text-blue-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <div>
                                    <p class="text-xs text-blue-200">Waktu Respons</p>
                                    <p class="font-medium">Maksimal 3 hari kerja</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

            <!-- Footer note -->
            <div class="mt-12 pt-8 border-t border-gray-200 text-center text-xs text-gray-400">
                <p>Kebijakan Privasi ini berlaku untuk aplikasi <strong>Moma</strong> versi Android dan iOS.</p>
                <p class="mt-1">© {{ date('Y') }} Moma. Seluruh hak cipta dilindungi undang-undang.</p>
                <a href="/" class="text-primary hover:underline mt-2 inline-block">← Kembali ke Beranda</a>
            </div>

        </div>
    </main>

</body>
</html>
