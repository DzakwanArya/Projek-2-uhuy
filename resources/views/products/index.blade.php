<x-app-layout>
  <style>
    .product-card {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(240, 240, 250, 1) 100%);
    }
    .product-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    .product-badge {
      position: absolute;
      top: 8px;
      right: 8px;
    }
    .stock-status {
      transition: all 0.3s ease;
    }
  </style>

  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <!-- Header Section -->
      <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
              🛍️ Jelajahi Produk
            </h1>
            <p class="text-slate-600 mt-2">Temukan alat tulis berkualitas dengan harga terbaik</p>
          </div>
          <div class="text-right">
            <p class="text-sm text-slate-500">Total: <span class="font-bold text-slate-900">{{ $products->total() }}</span> Produk</p>
          </div>
        </div>
      </div>

      <!-- Products Grid -->
      <div class="mb-8">
        @if($products->count() > 0)
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
              <div class="product-card rounded-2xl shadow p-5 border border-white/50 flex flex-col overflow-hidden">
                <!-- Product Image -->
                <div class="relative mb-3 overflow-hidden rounded-lg bg-white/50 h-40 flex items-center justify-center">
                  @php
                    $img = $product->image ? basename($product->image) : 'default-product.png';
                  @endphp
                  <img src="{{ asset('assets/img/' . $img) }}" alt="{{ $product->name }}" class="h-full w-full object-contain hover:scale-110 transition">
                  
                  <!-- Stock Badge -->
                  <div class="product-badge">
                    @if($product->stock > 50)
                      <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">✓ Stok Banyak</span>
                    @elseif($product->stock > 10)
                      <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">⚠️ Stok Terbatas</span>
                    @else
                      <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">⛔ Hampir Habis</span>
                    @endif
                  </div>
                </div>

                <!-- Product Info -->
                <h3 class="font-bold text-lg text-slate-900 mb-1 text-center line-clamp-2">{{ $product->name }}</h3>
                <p class="text-blue-600 font-bold text-lg mb-1 text-center">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-sm text-slate-500 mb-1 text-center">📂 {{ $product->category }}</p>
                
                <!-- Stock Info -->
                <p class="text-xs mb-3 text-center font-semibold stock-status {{ $product->stock <= 0 ? 'text-red-500' : 'text-green-600' }}">
                  📦 Stok: {{ $product->stock }} item
                </p>

                <!-- Description -->
                @if($product->description)
                  <p class="text-xs text-slate-600 mb-3 line-clamp-2">{{ $product->description }}</p>
                @endif

                <!-- Action Buttons -->
                <div class="mt-auto space-y-2">
                  <a href="{{ route('products.show', $product->id) }}" class="inline-block w-full text-center bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg font-semibold shadow hover:from-blue-600 hover:to-blue-700 transition">
                    👁️ Lihat Detail
                  </a>
                  <form action="{{ route('cart.add', $product->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="qty" value="1">
                    <button 
                      type="submit" 
                      class="w-full px-4 py-2 rounded-lg shadow font-bold text-white transition disabled:opacity-50 disabled:cursor-not-allowed
                        @if($product->stock <= 0)
                          bg-gray-400 hover:bg-gray-400
                        @else
                          bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-slate-900
                        @endif"
                      {{ $product->stock <= 0 ? 'disabled' : '' }}
                    >
                      @if($product->stock <= 0)
                        ❌ Stok Habis
                      @else
                        🛒 Keranjang
                      @endif
                    </button>
                  </form>
                </div>
              </div>
            @endforeach
          </div>

          <!-- Pagination -->
          <div class="mt-8 flex justify-center">
            {{ $products->links() }}
          </div>
        @else
          <div class="text-center py-16">
            <div class="text-6xl mb-4">📭</div>
            <h2 class="text-2xl font-bold text-slate-900 mb-2">Produk Tidak Tersedia</h2>
            <p class="text-slate-600 mb-6">Maaf, produk yang Anda cari tidak tersedia saat ini.</p>
            <a href="{{ route('home') }}" class="inline-block px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-semibold">
              ← Kembali ke Beranda
            </a>
          </div>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
