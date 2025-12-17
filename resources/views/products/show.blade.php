<x-app-layout>
  <style>
    .glass-effect {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }
  </style>

  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
      <!-- Breadcrumb -->
      <div class="mb-6 flex items-center gap-2 text-slate-600">
        <a href="{{ route('products.index') }}" class="hover:text-slate-900 transition">🛍️ Produk</a>
        <span>/</span>
        <span class="text-slate-900 font-semibold">{{ $product->name }}</span>
      </div>

      <!-- Main Product Section -->
      <div class="glass-effect rounded-2xl p-8 mb-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <!-- Product Image -->
          <div class="flex items-center justify-center">
            <div class="relative bg-white rounded-xl p-8 shadow-lg">
              @php $img = $product->image ? basename($product->image) : 'default-product.png'; @endphp
              <img src="{{ asset('assets/img/' . $img) }}" alt="{{ $product->name }}" class="max-h-96 object-contain hover:scale-105 transition">
              
              <!-- Stock Badge -->
              @if($product->stock <= 0)
                <div class="absolute top-4 left-4 bg-red-500 text-white px-4 py-2 rounded-full font-semibold">
                  ❌ Stok Habis
                </div>
              @elseif($product->stock <= 10)
                <div class="absolute top-4 left-4 bg-yellow-500 text-white px-4 py-2 rounded-full font-semibold">
                  ⚠️ Stok Terbatas
                </div>
              @else
                <div class="absolute top-4 left-4 bg-green-500 text-white px-4 py-2 rounded-full font-semibold">
                  ✓ Tersedia
                </div>
              @endif
            </div>
          </div>

          <!-- Product Details -->
          <div>
            <!-- Title and Category -->
            <div class="mb-6">
              <p class="text-slate-500 text-sm mb-2">📂 Kategori: <span class="font-semibold text-slate-900">{{ $product->category }}</span></p>
              <h1 class="text-4xl font-bold text-slate-900 mb-2">{{ $product->name }}</h1>
            </div>

            <!-- Price -->
            <div class="mb-6 pb-6 border-b border-slate-200">
              <p class="text-slate-600 text-sm mb-2">Harga</p>
              <p class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                Rp{{ number_format($product->price, 0, ',', '.') }}
              </p>
            </div>

            <!-- Stock Info -->
            <div class="mb-6 pb-6 border-b border-slate-200">
              <p class="text-slate-600 text-sm mb-2">📦 Stok Tersedia</p>
              <p class="text-2xl font-bold {{ $product->stock <= 0 ? 'text-red-600' : 'text-green-600' }}">
                {{ $product->stock }} item
              </p>
            </div>

            <!-- Description -->
            @if($product->description)
              <div class="mb-6 pb-6 border-b border-slate-200">
                <p class="text-slate-600 text-sm mb-2">📝 Deskripsi</p>
                <p class="text-slate-700 leading-relaxed">{{ $product->description }}</p>
              </div>
            @endif

            <!-- Add to Cart Form -->
            <form action="{{ route('cart.add', $product->id) }}" method="post" class="mb-6">
              @csrf
              <div class="mb-4">
                <label class="block font-semibold text-slate-900 mb-2">🛒 Jumlah Pesanan</label>
                <div class="flex items-center gap-4">
                  <input 
                    type="number" 
                    name="qty" 
                    value="1" 
                    min="1" 
                    max="{{ max(1, $product->stock) }}" 
                    class="w-32 border-2 border-slate-300 rounded-lg px-4 py-3 font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                    {{ $product->stock <= 0 ? 'disabled' : '' }}
                  >
                  <span class="text-slate-600">Max: <span class="font-bold">{{ $product->stock }}</span></span>
                </div>
              </div>

              <!-- Buttons -->
              <div class="flex flex-col sm:flex-row gap-4">
                <button 
                  type="submit" 
                  class="flex-1 px-6 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-slate-900 rounded-lg font-bold text-lg hover:from-yellow-500 hover:to-yellow-600 transition disabled:opacity-50 disabled:cursor-not-allowed shadow-lg"
                  {{ $product->stock <= 0 ? 'disabled' : '' }}
                >
                  @if($product->stock <= 0)
                    ❌ Tidak Dapat Dipesan
                  @else
                    🛒 Tambah ke Keranjang
                  @endif
                </button>
                <a 
                  href="{{ route('cart.index') }}" 
                  class="flex-1 px-6 py-4 border-2 border-blue-500 text-blue-600 rounded-lg font-bold text-lg hover:bg-blue-50 transition text-center"
                >
                  👜 Lihat Keranjang
                </a>
              </div>
            </form>

            <!-- Additional Info -->
            <div class="bg-slate-50 rounded-lg p-4 mb-6">
              <div class="flex items-start gap-3 text-sm text-slate-600">
                <span>✓</span>
                <span>Garansi kualitas produk terbaik</span>
              </div>
              <div class="flex items-start gap-3 text-sm text-slate-600 mt-2">
                <span>✓</span>
                <span>Pengiriman cepat ke seluruh Indonesia</span>
              </div>
              <div class="flex items-start gap-3 text-sm text-slate-600 mt-2">
                <span>✓</span>
                <span>Jaminan uang kembali 100% jika tidak puas</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Related Products Section -->
      <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">🎯 Produk Terkait</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          @php
            $relatedProducts = \App\Models\Product::where('category', $product->category)
              ->where('id', '!=', $product->id)
              ->limit(4)
              ->get();
          @endphp
          @forelse($relatedProducts as $related)
            <div class="glass-effect rounded-lg p-4 hover:shadow-lg transition">
              <div class="bg-white rounded-lg h-32 flex items-center justify-center mb-3">
                @php $img = $related->image ? basename($related->image) : 'default-product.png'; @endphp
                <img src="{{ asset('assets/img/' . $img) }}" alt="{{ $related->name }}" class="h-full w-full object-contain">
              </div>
              <h3 class="font-semibold text-slate-900 line-clamp-2 mb-2">{{ $related->name }}</h3>
              <p class="text-blue-600 font-bold mb-2">Rp{{ number_format($related->price, 0, ',', '.') }}</p>
              <a href="{{ route('products.show', $related->id) }}" class="inline-block w-full text-center bg-blue-500 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-600 transition">
                Lihat
              </a>
            </div>
          @empty
            <div class="col-span-full text-center py-8 text-slate-500">
              Tidak ada produk terkait
            </div>
          @endforelse
        </div>
      </div>

      <!-- Back Button -->
      <div class="text-center">
        <a href="{{ route('products.index') }}" class="inline-block px-6 py-3 bg-slate-300 hover:bg-slate-400 text-slate-900 rounded-lg font-semibold transition">
          ← Kembali ke Produk
        </a>
      </div>
    </div>
  </div>
</x-app-layout>
