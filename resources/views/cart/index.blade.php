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
          🛒 Keranjang Belanja
        </h1>
        <p class="text-slate-600 mt-2">Periksa dan lanjutkan pembelian Anda</p>
      </div>

      @if(count($items) == 0)
        <!-- Empty Cart -->
        <div class="glass-effect rounded-2xl p-12 text-center">
          <div class="text-6xl mb-4">📭</div>
          <h2 class="text-2xl font-bold text-slate-900 mb-2">Keranjang Kosong</h2>
          <p class="text-slate-600 mb-6">Anda belum menambahkan produk ke keranjang. Mari mulai belanja!</p>
          <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition">
            🛍️ Jelajahi Produk
          </a>
        </div>
      @else
        <!-- Cart Items -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Items List -->
          <div class="lg:col-span-2">
            <div class="glass-effect rounded-2xl overflow-hidden">
              @php $total = 0; @endphp
              @foreach($items as $it)
                @php 
                  $p = $it->product ?? (object)($it['product'] ?? null); 
                  $qty = $it->qty ?? $it['qty']; 
                  $subtotal = ($p->price ?? 0) * $qty; 
                  $total += $subtotal;
                @endphp
                <div class="p-6 border-b border-slate-200 hover:bg-slate-50 transition">
                  <div class="flex gap-4">
                    <!-- Product Image -->
                    <div class="w-24 h-24 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                      @php $img = $p->image ? basename($p->image) : 'default-product.png'; @endphp
                      <img src="{{ asset('assets/img/' . $img) }}" alt="{{ $p->name ?? 'Produk' }}" class="w-full h-full object-contain">
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1">
                      <h3 class="text-lg font-bold text-slate-900 mb-1">
                        {{ $p->name ?? 'Produk tidak ditemukan' }}
                      </h3>
                      <p class="text-blue-600 font-semibold mb-3">
                        Rp{{ number_format($p->price ?? 0, 0, ',', '.') }}
                      </p>
                      <div class="flex items-center gap-3">
                        <span class="text-slate-600 font-medium">Qty:</span>
                        <span class="bg-slate-100 px-3 py-1 rounded font-semibold">{{ $qty }}</span>
                        <span class="text-slate-600">Subtotal:</span>
                        <span class="font-bold text-slate-900">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                      </div>
                    </div>

                    <!-- Remove Button -->
                    <div class="flex flex-col gap-2 justify-center">
                      <form action="{{ route('cart.remove', $p->id ?? $it['product_id']) }}" method="post">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition">
                          🗑️ Hapus
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>

            <!-- Continue Shopping -->
            <div class="mt-6">
              <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 text-blue-600 font-semibold hover:text-blue-700 transition">
                ← Lanjutkan Belanja
              </a>
            </div>
          </div>

          <!-- Summary -->
          <div class="lg:col-span-1">
            <div class="glass-effect rounded-2xl p-6 sticky top-24">
              <h2 class="text-2xl font-bold text-slate-900 mb-6">📊 Ringkasan Pesanan</h2>

              <!-- Items Count -->
              <div class="flex justify-between mb-4 pb-4 border-b border-slate-200">
                <span class="text-slate-600">Jumlah Item</span>
                <span class="font-semibold text-slate-900">{{ count($items) }} produk</span>
              </div>

              <!-- Subtotal -->
              <div class="flex justify-between mb-4 pb-4 border-b border-slate-200">
                <span class="text-slate-600">Subtotal</span>
                <span class="font-semibold text-slate-900">Rp{{ number_format($total, 0, ',', '.') }}</span>
              </div>

              <!-- Shipping (Dummy) -->
              <div class="flex justify-between mb-4 pb-4 border-b border-slate-200">
                <span class="text-slate-600">Ongkir</span>
                <span class="font-semibold text-slate-900">Rp0 (Gratis)</span>
              </div>

              <!-- Total -->
              <div class="flex justify-between mb-6">
                <span class="text-lg font-bold text-slate-900">Total</span>
                <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                  Rp{{ number_format($total, 0, ',', '.') }}
                </span>
              </div>

              <!-- Checkout Button -->
              <a href="{{ route('checkout') }}" class="w-full block text-center px-6 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-slate-900 rounded-lg font-bold text-lg hover:from-yellow-500 hover:to-yellow-600 transition shadow-lg mb-3">
                ✓ Lanjut Checkout
              </a>

              <!-- Info -->
              <div class="bg-blue-50 rounded-lg p-4 text-sm text-blue-800">
                <p class="flex items-center gap-2">
                  <span>ℹ️</span>
                  <span>Pilihan pembayaran tersedia di halaman checkout</span>
                </p>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
</x-app-layout>
