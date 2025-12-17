<x-app-layout>
  <style>
    .glass-effect {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }
  </style>

  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
          ✓ Checkout
        </h1>
        <p class="text-slate-600 mt-2">Selesaikan pesanan Anda dengan mengisi informasi di bawah</p>
      </div>

      @if(count($items) == 0)
        <!-- Empty Cart -->
        <div class="glass-effect rounded-2xl p-12 text-center">
          <div class="text-6xl mb-4">📭</div>
          <h2 class="text-2xl font-bold text-slate-900 mb-2">Keranjang Kosong</h2>
          <p class="text-slate-600 mb-6">Tidak ada produk untuk di-checkout. Silakan tambahkan produk terlebih dahulu.</p>
          <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition">
            🛍️ Jelajahi Produk
          </a>
        </div>
      @else
        <!-- Checkout Form -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Form Section -->
          <div class="lg:col-span-2">
            <form action="{{ route('order.place') }}" method="post" class="space-y-6">
              @csrf

              <!-- Personal Info Section -->
              <div class="glass-effect rounded-2xl p-6">
                <h2 class="text-xl font-bold text-slate-900 mb-4">👤 Informasi Pribadi</h2>
                
                <div class="space-y-4">
                  <!-- Nama Lengkap -->
                  <div>
                    <label class="block font-semibold text-slate-900 mb-2">Nama Lengkap</label>
                    <input 
                      type="text" 
                      name="customer_name" 
                      value="{{ Auth::user()->name ?? old('customer_name') }}"
                      required 
                      class="w-full border-2 border-slate-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                      placeholder="Masukkan nama lengkap Anda"
                    >
                    @error('customer_name')
                      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                  </div>

                  <!-- Nomor Telepon -->
                  <div>
                    <label class="block font-semibold text-slate-900 mb-2">Nomor Telepon</label>
                    <input 
                      type="tel" 
                      name="customer_phone" 
                      value="{{ old('customer_phone') }}"
                      required 
                      class="w-full border-2 border-slate-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                      placeholder="Contoh: 08123456789"
                    >
                    @error('customer_phone')
                      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                  </div>

                  <!-- Email -->
                  <div>
                    <label class="block font-semibold text-slate-900 mb-2">Email</label>
                    <input 
                      type="email" 
                      name="email" 
                      value="{{ Auth::user()->email ?? old('email') }}"
                      class="w-full border-2 border-slate-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                      placeholder="Email Anda"
                    >
                  </div>
                </div>
              </div>

              <!-- Shipping Info Section -->
              <div class="glass-effect rounded-2xl p-6">
                <h2 class="text-xl font-bold text-slate-900 mb-4">📍 Alamat Pengiriman</h2>
                
                <div class="space-y-4">
                  <!-- Alamat -->
                  <div>
                    <label class="block font-semibold text-slate-900 mb-2">Alamat Lengkap</label>
                    <textarea 
                      name="address" 
                      required
                      rows="4"
                      class="w-full border-2 border-slate-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition resize-none"
                      placeholder="Masukkan alamat pengiriman lengkap (jalan, nomor rumah, kota, provinsi, kode pos)"
                    >{{ old('address') }}</textarea>
                    @error('address')
                      <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                  </div>

                  <!-- Catatan -->
                  <div>
                    <label class="block font-semibold text-slate-900 mb-2">Catatan (Opsional)</label>
                    <textarea 
                      name="notes"
                      rows="2"
                      class="w-full border-2 border-slate-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition resize-none"
                      placeholder="Contoh: Biarkan di depan pintu, jangan bunyikan bel"
                    >{{ old('notes') }}</textarea>
                  </div>
                </div>
              </div>

              <!-- Shipping Method -->
              <div class="glass-effect rounded-2xl p-6">
                <h2 class="text-xl font-bold text-slate-900 mb-4">🚚 Metode Pengiriman</h2>
                
                <div class="space-y-3">
                  <label class="flex items-center p-3 border-2 border-slate-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="shipping_method" value="regular" checked class="mr-3">
                    <span class="font-semibold text-slate-900">Regular (3-5 hari kerja)</span>
                    <span class="ml-auto text-green-600 font-bold">Gratis</span>
                  </label>
                  <label class="flex items-center p-3 border-2 border-slate-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="shipping_method" value="express" class="mr-3">
                    <span class="font-semibold text-slate-900">Express (1-2 hari kerja)</span>
                    <span class="ml-auto text-slate-600 font-bold">+Rp50.000</span>
                  </label>
                </div>
              </div>

              <!-- Terms & Conditions -->
              <div class="glass-effect rounded-2xl p-6">
                <label class="flex items-start gap-3 cursor-pointer">
                  <input type="checkbox" name="agree_terms" required class="mt-1">
                  <span class="text-slate-600">
                    Saya setuju dengan <span class="font-semibold text-slate-900">Syarat & Ketentuan</span> dan <span class="font-semibold text-slate-900">Kebijakan Privasi</span>
                  </span>
                </label>
              </div>

              <!-- Submit Button -->
              <button 
                type="submit" 
                class="w-full px-6 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-slate-900 rounded-lg font-bold text-lg hover:from-yellow-500 hover:to-yellow-600 transition shadow-lg"
              >
                ✓ Konfirmasi & Lanjutkan Pembayaran
              </button>
            </form>
          </div>

          <!-- Order Summary Section -->
          <div class="lg:col-span-1">
            <div class="glass-effect rounded-2xl p-6 sticky top-24">
              <h2 class="text-xl font-bold text-slate-900 mb-4">📋 Ringkasan Pesanan</h2>

              <!-- Items List -->
              <div class="space-y-3 mb-4 pb-4 border-b border-slate-200">
                @php $total = 0; @endphp
                @foreach($items as $it)
                  @php 
                    $p = $it->product ?? (object)($it['product'] ?? null); 
                    $qty = $it->qty ?? $it['qty']; 
                    $subtotal = ($p->price ?? 0) * $qty; 
                    $total += $subtotal;
                  @endphp
                  <div class="flex justify-between items-start">
                    <div class="flex-1">
                      <p class="font-semibold text-slate-900 text-sm">{{ $p->name ?? 'Produk' }}</p>
                      <p class="text-xs text-slate-500">x{{ $qty }}</p>
                    </div>
                    <p class="font-semibold text-slate-900 text-sm">Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
                  </div>
                @endforeach
              </div>

              <!-- Cost Breakdown -->
              <div class="space-y-2 mb-4 pb-4 border-b border-slate-200">
                <div class="flex justify-between text-slate-600">
                  <span>Subtotal</span>
                  <span class="font-semibold">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-slate-600">
                  <span>Ongkir</span>
                  <span class="font-semibold">Rp0 (Gratis)</span>
                </div>
                <div class="flex justify-between text-slate-600">
                  <span>Pajak</span>
                  @php $tax = $total * 0.1; @endphp
                  <span class="font-semibold">Rp{{ number_format($tax, 0, ',', '.') }}</span>
                </div>
              </div>

              <!-- Total -->
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-slate-900">Total Bayar</span>
                @php $finalTotal = $total + $tax; @endphp
                <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                  Rp{{ number_format($finalTotal, 0, ',', '.') }}
                </span>
              </div>

              <!-- Info Box -->
              <div class="mt-6 bg-blue-50 rounded-lg p-3 text-sm text-blue-800">
                <p class="flex items-start gap-2">
                  <span>ℹ️</span>
                  <span>Anda akan diarahkan ke halaman pembayaran setelah mengklik tombol di atas</span>
                </p>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
</x-app-layout>
