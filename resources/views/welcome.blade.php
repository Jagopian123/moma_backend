<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Moma — Catat Keuangan Lebih Cerdas</title>
  <meta name="description" content="Moma adalah aplikasi keuangan pribadi berbasis AI yang membantu kamu mencatat, menganalisis, dan merencanakan keuangan dengan mudah." />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#2563EB',
            'primary-light': '#3B82F6',
            'primary-dark': '#1D4ED8',
            'primary-50': '#EFF6FF',
            'primary-100': '#DBEAFE',
          },
          fontFamily: {
            sans: ['Poppins', 'sans-serif'],
          },
        },
      },
    }
  </script>

  <style>
    * { font-family: 'Poppins', sans-serif; }

    .gradient-bg {
      background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
    }

    .gradient-text {
      background: linear-gradient(135deg, #2563EB, #3B82F6);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .card-hover {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-hover:hover {
      transform: translateY(-4px);
      box-shadow: 0 20px 40px rgba(37, 99, 235, 0.15);
    }

    .fade-in {
      opacity: 0;
      transform: translateY(24px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .fade-in.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .blob {
      border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
    }

    .phone-shadow {
      box-shadow: 0 40px 80px rgba(37, 99, 235, 0.3), 0 0 0 1px rgba(37,99,235,0.1);
    }
  </style>
</head>

<body class="bg-white text-gray-900 overflow-x-hidden">

  <!-- ── NAVBAR ──────────────────────────────────────────────────────── -->
  <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <span class="text-lg font-bold text-gray-900">Moma</span>
      </div>

      <div class="hidden md:flex items-center gap-8">
        <a href="#fitur" class="text-sm text-gray-600 hover:text-primary font-medium transition-colors">Fitur</a>
        <a href="#ai" class="text-sm text-gray-600 hover:text-primary font-medium transition-colors">AI</a>
        <a href="#cara-kerja" class="text-sm text-gray-600 hover:text-primary font-medium transition-colors">Cara Kerja</a>
        <a href="#keamanan" class="text-sm text-gray-600 hover:text-primary font-medium transition-colors">Keamanan</a>
      </div>

      <a href="#download"
        class="gradient-bg text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:opacity-90 transition-opacity">
        Download Gratis
      </a>
    </div>
  </nav>

  <!-- ── HERO ────────────────────────────────────────────────────────── -->
  <section class="pt-28 pb-20 px-6 relative overflow-hidden">
    <div class="absolute top-20 right-0 w-96 h-96 bg-blue-50 blob opacity-60 -z-10"></div>
    <div class="absolute bottom-0 left-0 w-72 h-72 bg-blue-50 blob opacity-80 -z-10"></div>

    <div class="max-w-6xl mx-auto">
      <div class="flex flex-col lg:flex-row items-center gap-16">

        <!-- Left: Text -->
        <div class="flex-1 text-center lg:text-left">
          <div class="inline-flex items-center gap-2 bg-primary-50 text-primary text-xs font-semibold px-4 py-2 rounded-full mb-6">
            <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
            Didukung Kecerdasan Buatan
          </div>

          <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
            Catat Keuangan<br />
            <span class="gradient-text">Lebih Cerdas</span><br />
            Bersama AI
          </h1>

          <p class="text-gray-500 text-lg leading-relaxed mb-8 max-w-xl mx-auto lg:mx-0">
            Moma membantu kamu mencatat pemasukan & pengeluaran, menganalisis kebiasaan finansial, dan merencanakan masa depan keuangan — semua dengan bantuan AI.
          </p>

          <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
            <a href="#download"
              class="gradient-bg text-white font-semibold px-8 py-4 rounded-2xl hover:opacity-90 transition-opacity text-center flex items-center justify-center gap-2">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3.18 23.76c.3.17.64.24.99.2l12.45-12.45L13.2 8.1 3.18 23.76zm17.1-11.53c.46-.27.72-.73.72-1.23s-.26-.96-.72-1.23l-2.91-1.68-3.18 3.18 3.18 3.18 2.91-1.22zM3.54.46C3.2.1 2.7-.07 2.22.03L13.2 11.01l3.42-3.42L3.54.46zM2.22.03C1.7.13 1.32.6 1.32 1.17v21.66c0 .57.38 1.04.9 1.14L13.2 12.99 2.22.03z"/>
              </svg>
              Google Play
            </a>
            <a href="#fitur"
              class="border-2 border-gray-200 text-gray-700 font-semibold px-8 py-4 rounded-2xl hover:border-primary hover:text-primary transition-colors text-center">
              Lihat Fitur
            </a>
          </div>

          <div class="flex gap-8 mt-12 justify-center lg:justify-start">
            <div>
              <div class="text-2xl font-bold text-gray-900">100%</div>
              <div class="text-xs text-gray-500 font-medium">Gratis Dipakai</div>
            </div>
            <div class="w-px bg-gray-200"></div>
            <div>
              <div class="text-2xl font-bold text-gray-900">AI</div>
              <div class="text-xs text-gray-500 font-medium">Powered</div>
            </div>
            <div class="w-px bg-gray-200"></div>
            <div>
              <div class="text-2xl font-bold text-gray-900">Aman</div>
              <div class="text-xs text-gray-500 font-medium">PIN & Biometrik</div>
            </div>
          </div>
        </div>

        <!-- Right: Phone Mockup -->
        <div class="flex-1 flex justify-center">
          <div class="relative">
            <div class="absolute inset-0 gradient-bg rounded-[3rem] blur-3xl opacity-20 scale-110"></div>
            <div class="relative w-64 bg-gray-900 rounded-[3rem] phone-shadow p-3">
              <div class="bg-white rounded-[2.4rem] overflow-hidden">
                <div class="gradient-bg h-14 flex items-end px-5 pb-2">
                  <span class="text-white font-bold text-lg">Moma</span>
                </div>
                <div class="p-4 space-y-3 bg-gray-50">
                  <div class="gradient-bg rounded-2xl p-4 text-white">
                    <div class="text-xs opacity-70 mb-1">Total Saldo</div>
                    <div class="text-xl font-bold">Rp 12.500.000</div>
                    <div class="flex gap-4 mt-3">
                      <div>
                        <div class="text-xs opacity-70">Pemasukan</div>
                        <div class="text-sm font-semibold">+Rp 5jt</div>
                      </div>
                      <div>
                        <div class="text-xs opacity-70">Pengeluaran</div>
                        <div class="text-sm font-semibold">-Rp 2.5jt</div>
                      </div>
                    </div>
                  </div>
                  <div class="bg-white rounded-xl p-3 space-y-2">
                    <div class="text-xs font-semibold text-gray-500 mb-2">Transaksi Terbaru</div>
                    <div class="flex items-center gap-2">
                      <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center text-xs">🍕</div>
                      <div class="flex-1">
                        <div class="text-xs font-medium">Makan Siang</div>
                        <div class="text-xs text-gray-400">Hari ini</div>
                      </div>
                      <div class="text-xs font-semibold text-red-500">-35K</div>
                    </div>
                    <div class="flex items-center gap-2">
                      <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center text-xs">💼</div>
                      <div class="flex-1">
                        <div class="text-xs font-medium">Gaji</div>
                        <div class="text-xs text-gray-400">Kemarin</div>
                      </div>
                      <div class="text-xs font-semibold text-green-500">+5jt</div>
                    </div>
                  </div>
                  <div class="bg-white rounded-xl p-3">
                    <div class="text-xs font-semibold text-gray-500 mb-2">AI Assistant</div>
                    <div class="bg-blue-50 rounded-lg p-2">
                      <p class="text-xs text-primary font-medium">"tadi beli kopi 35rb"</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-2 mt-1">
                      <p class="text-xs text-gray-600">✓ Dicatat! Pengeluaran Rp 35.000</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ── FITUR UTAMA ──────────────────────────────────────────────── -->
  <section id="fitur" class="py-20 px-6 bg-gray-50">
    <div class="max-w-6xl mx-auto">
      <div class="text-center mb-16 fade-in">
        <div class="inline-flex items-center gap-2 bg-primary-50 text-primary text-xs font-semibold px-4 py-2 rounded-full mb-4">
          Fitur Lengkap
        </div>
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
          Semua yang kamu butuhkan<br />untuk keuangan sehat
        </h2>
        <p class="text-gray-500 max-w-xl mx-auto">
          Dari pencatatan harian hingga perencanaan jangka panjang, Moma hadir sebagai teman finansial kamu sehari-hari.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <div class="bg-white rounded-2xl p-6 card-hover fade-in border border-gray-100">
          <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">Catat Transaksi Mudah</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Tambah pemasukan & pengeluaran dalam hitungan detik. Kategorisasi otomatis yang cerdas.</p>
        </div>

        <div class="bg-white rounded-2xl p-6 card-hover fade-in border border-gray-100">
          <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">Analitik & Insights</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Grafik cashflow, donut chart kategori, dan health score keuangan kamu setiap saat.</p>
        </div>

        <div class="bg-white rounded-2xl p-6 card-hover fade-in border border-gray-100">
          <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
            </svg>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">Budget & Batas Pengeluaran</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Atur budget per kategori. Dapat notifikasi saat mendekati batas yang kamu tetapkan.</p>
        </div>

        <div class="bg-white rounded-2xl p-6 card-hover fade-in border border-gray-100">
          <div class="w-12 h-12 bg-yellow-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">Manajemen Aset</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Pantau dompet, investasi, tabungan, dan semua aset kamu dalam satu tampilan terpadu.</p>
        </div>

        <div class="bg-white rounded-2xl p-6 card-hover fade-in border border-gray-100">
          <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">Rencana Finansial</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Buat target tabungan dan lacak progressnya. Dari beli HP baru sampai dana darurat.</p>
        </div>

        <div class="bg-white rounded-2xl p-6 card-hover fade-in border border-gray-100">
          <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
          <h3 class="text-lg font-bold text-gray-900 mb-2">Hutang & Piutang</h3>
          <p class="text-gray-500 text-sm leading-relaxed">Catat siapa yang hutang ke kamu dan sebaliknya. Tidak ada yang terlewat lagi.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- ── AI FEATURES ──────────────────────────────────────────────── -->
  <section id="ai" class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
      <div class="flex flex-col lg:flex-row items-center gap-16">

        <div class="flex-1 fade-in">
          <div class="inline-flex items-center gap-2 bg-primary-50 text-primary text-xs font-semibold px-4 py-2 rounded-full mb-6">
            ✨ Powered by AI
          </div>
          <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6">
            Catat transaksi cukup<br />
            <span class="gradient-text">ngobrol saja</span>
          </h2>
          <p class="text-gray-500 mb-10 leading-relaxed">
            Tidak perlu isi form panjang. Ceritakan saja ke AI Moma — dia yang akan mencatat, mengkategorikan, dan menganalisis keuanganmu secara otomatis.
          </p>

          <div class="space-y-6">
            <div class="flex items-start gap-4">
              <div class="w-10 h-10 gradient-bg rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-900 mb-1">Chat AI</h4>
                <p class="text-gray-500 text-sm">Ketik "beli bensin 50rb" — langsung tercatat. Tanya "bulan ini boros gak?" — AI langsung analisis.</p>
              </div>
            </div>

            <div class="flex items-start gap-4">
              <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-900 mb-1">Foto Struk</h4>
                <p class="text-gray-500 text-sm">Foto struk belanjaan, AI langsung scan dan catat semua transaksi secara otomatis.</p>
              </div>
            </div>

            <div class="flex items-start gap-4">
              <div class="w-10 h-10 bg-green-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                </svg>
              </div>
              <div>
                <h4 class="font-bold text-gray-900 mb-1">Voice Note</h4>
                <p class="text-gray-500 text-sm">Lagi di jalan? Rekam suara "tadi makan siang dua puluh ribu" — AI paham dan langsung catat.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Chat preview -->
        <div class="flex-1 fade-in">
          <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
              <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2" />
                </svg>
              </div>
              <div>
                <div class="font-bold text-gray-900 text-sm">Moma AI</div>
                <div class="text-xs text-green-500 font-medium">● Online</div>
              </div>
            </div>

            <div class="space-y-4">
              <div class="flex justify-end">
                <div class="bg-primary text-white rounded-2xl rounded-tr-sm px-4 py-3 max-w-xs">
                  <p class="text-sm">tadi beli kopi sama roti 45rb</p>
                  <p class="text-xs opacity-60 mt-1">09:15</p>
                </div>
              </div>
              <div class="flex justify-start">
                <div class="bg-white rounded-2xl rounded-tl-sm px-4 py-3 max-w-xs shadow-sm border border-gray-100">
                  <p class="text-sm text-gray-800">✅ Dicatat! Pengeluaran <strong>Makanan & Minuman</strong> Rp 45.000</p>
                  <p class="text-xs text-gray-400 mt-1">09:15</p>
                </div>
              </div>
              <div class="flex justify-end">
                <div class="bg-primary text-white rounded-2xl rounded-tr-sm px-4 py-3 max-w-xs">
                  <p class="text-sm">bulan ini pengeluaran saya gimana?</p>
                  <p class="text-xs opacity-60 mt-1">09:20</p>
                </div>
              </div>
              <div class="flex justify-start">
                <div class="bg-white rounded-2xl rounded-tl-sm px-4 py-3 max-w-xs shadow-sm border border-gray-100">
                  <p class="text-sm text-gray-800">📊 Sudah habis <strong>Rp 2.4jt</strong> dari budget <strong>Rp 3jt</strong>. Terbesar di Makanan (Rp 890rb). Masih aman! 💪</p>
                  <p class="text-xs text-gray-400 mt-1">09:20</p>
                </div>
              </div>
              <div class="flex justify-start">
                <div class="bg-white rounded-2xl px-4 py-3 shadow-sm border border-gray-100">
                  <div class="flex gap-1">
                    <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay:0ms"></div>
                    <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay:150ms"></div>
                    <div class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay:300ms"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ── CARA KERJA ───────────────────────────────────────────────── -->
  <section id="cara-kerja" class="py-20 px-6 bg-gray-50">
    <div class="max-w-4xl mx-auto text-center">
      <div class="fade-in">
        <div class="inline-flex items-center gap-2 bg-primary-50 text-primary text-xs font-semibold px-4 py-2 rounded-full mb-4">
          Mudah Digunakan
        </div>
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Mulai dalam 3 langkah</h2>
        <p class="text-gray-500 mb-16">Tidak perlu setup rumit. Langsung pakai.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="fade-in text-center">
          <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold shadow-lg">1</div>
          <h3 class="font-bold text-gray-900 mb-2">Download & Daftar</h3>
          <p class="text-gray-500 text-sm">Download Moma di Google Play, daftar dengan email atau Google — gratis, tidak perlu kartu kredit.</p>
        </div>
        <div class="fade-in text-center">
          <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold shadow-lg">2</div>
          <h3 class="font-bold text-gray-900 mb-2">Setup Dompet</h3>
          <p class="text-gray-500 text-sm">Tambahkan dompet dan saldo awal kamu. Bisa rekening bank, dompet digital, atau kas tunai.</p>
        </div>
        <div class="fade-in text-center">
          <div class="w-16 h-16 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold shadow-lg">3</div>
          <h3 class="font-bold text-gray-900 mb-2">Mulai Catat</h3>
          <p class="text-gray-500 text-sm">Chat dengan AI, foto struk, atau isi manual. Keuanganmu langsung tercatat dan teranalisis otomatis.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ── KEAMANAN ─────────────────────────────────────────────────── -->
  <section id="keamanan" class="py-20 px-6">
    <div class="max-w-6xl mx-auto">
      <div class="gradient-bg rounded-3xl p-10 md:p-16 text-white overflow-hidden relative">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 blob"></div>
        <div class="absolute bottom-0 left-20 w-48 h-48 bg-white/5 blob"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-center gap-12">
          <div class="flex-1 fade-in">
            <div class="inline-flex items-center gap-2 bg-white/10 text-white text-xs font-semibold px-4 py-2 rounded-full mb-6">
              🔒 Keamanan Berlapis
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4">
              Data keuanganmu<br />aman bersama Moma
            </h2>
            <p class="text-white/70 leading-relaxed mb-8">
              Kami serius soal keamanan. Moma dilengkapi enkripsi data, autentikasi berlapis, dan backup cloud sehingga data kamu tidak pernah hilang.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" /></svg>
                </div>
                <span class="text-sm font-medium">Sidik Jari / Face ID</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                </div>
                <span class="text-sm font-medium">PIN Terenkripsi</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" /></svg>
                </div>
                <span class="text-sm font-medium">Cloud Backup Otomatis</span>
              </div>
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                </div>
                <span class="text-sm font-medium">Data Terlindungi</span>
              </div>
            </div>
          </div>

          <div class="flex-shrink-0 fade-in">
            <div class="w-32 h-32 bg-white/10 rounded-3xl flex items-center justify-center">
              <svg class="w-16 h-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ── DOWNLOAD CTA ─────────────────────────────────────────────── -->
  <section id="download" class="py-20 px-6 bg-gray-50">
    <div class="max-w-3xl mx-auto text-center fade-in">
      <div class="inline-flex items-center gap-2 bg-primary-50 text-primary text-xs font-semibold px-4 py-2 rounded-full mb-6">
        100% Gratis
      </div>
      <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">
        Mulai perjalanan finansialmu<br />sekarang juga
      </h2>
      <p class="text-gray-500 mb-10">
        Bergabunglah dan rasakan kemudahan mencatat keuangan dengan bantuan AI. Gratis selamanya.
      </p>

      <a href="#"
        class="inline-flex items-center gap-3 gradient-bg text-white font-semibold px-8 py-4 rounded-2xl hover:opacity-90 transition-opacity">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
          <path d="M3.18 23.76c.3.17.64.24.99.2l12.45-12.45L13.2 8.1 3.18 23.76zm17.1-11.53c.46-.27.72-.73.72-1.23s-.26-.96-.72-1.23l-2.91-1.68-3.18 3.18 3.18 3.18 2.91-1.22zM3.54.46C3.2.1 2.7-.07 2.22.03L13.2 11.01l3.42-3.42L3.54.46zM2.22.03C1.7.13 1.32.6 1.32 1.17v21.66c0 .57.38 1.04.9 1.14L13.2 12.99 2.22.03z"/>
        </svg>
        <div class="text-left">
          <div class="text-xs opacity-80">Download di</div>
          <div class="font-bold">Google Play</div>
        </div>
      </a>

      <p class="text-xs text-gray-400 mt-6">Tersedia untuk Android • iOS segera hadir</p>
    </div>
  </section>

  <!-- ── FOOTER ───────────────────────────────────────────────────── -->
  <footer class="bg-gray-900 text-white py-12 px-6">
    <div class="max-w-6xl mx-auto">
      <div class="flex flex-col md:flex-row justify-between items-start gap-8 mb-10">
        <div>
          <div class="flex items-center gap-2 mb-3">
            <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <span class="font-bold text-lg">Moma</span>
          </div>
          <p class="text-gray-400 text-sm max-w-xs">Catat keuangan lebih cerdas bersama AI. Gratis untuk semua.</p>
        </div>

        <div class="flex gap-16">
          <div>
            <div class="font-semibold mb-4 text-sm">Produk</div>
            <div class="space-y-2">
              <a href="#fitur" class="block text-gray-400 text-sm hover:text-white transition-colors">Fitur</a>
              <a href="#ai" class="block text-gray-400 text-sm hover:text-white transition-colors">AI Assistant</a>
              <a href="#keamanan" class="block text-gray-400 text-sm hover:text-white transition-colors">Keamanan</a>
            </div>
          </div>
          <div>
            <div class="font-semibold mb-4 text-sm">Legal</div>
            <div class="space-y-2">
              <a href="#" class="block text-gray-400 text-sm hover:text-white transition-colors">Kebijakan Privasi</a>
              <a href="#" class="block text-gray-400 text-sm hover:text-white transition-colors">Syarat & Ketentuan</a>
            </div>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-800 pt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <p class="text-gray-500 text-sm">© 2026 Moma. Semua hak dilindungi.</p>
        <p class="text-gray-600 text-xs">Made with ❤️ in Indonesia</p>
      </div>
    </div>
  </footer>

  <script>
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('visible');
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
  </script>

</body>
</html>
