<x-app-layout>
    <style>
        .gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-success {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .gradient-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .gradient-warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
                            Selamat Datang, {{ Auth::user()->name }}! 👋
                        </h1>
                        <p class="text-slate-600 mt-2">Dashboard pelanggan - Kelola pesanan dan profil Anda</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-500">{{ now()->translatedFormat('l, j F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- User Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- My Orders -->
                <div class="glass-effect rounded-2xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-sm font-medium">Pesanan Saya</p>
                            @php $myOrders = \App\Models\Order::where('user_id', Auth::id())->count(); @endphp
                            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $myOrders }}</p>
                            <p class="text-xs text-slate-500 mt-2">🛍️ Total pesanan</p>
                        </div>
                        <div class="stat-icon gradient-primary text-white">📦</div>
                    </div>
                </div>

                <!-- Pending Pesanan -->
                <div class="glass-effect rounded-2xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-sm font-medium">Pesanan Tertunda</p>
                            @php $pendingOrders = \App\Models\Order::where('user_id', Auth::id())->where('status', 'pending')->count(); @endphp
                            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $pendingOrders }}</p>
                            <p class="text-xs text-slate-500 mt-2">⏳ Perlu diproses</p>
                        </div>
                        <div class="stat-icon gradient-warning text-white">⏳</div>
                    </div>
                </div>

                <!-- Total Spending -->
                <div class="glass-effect rounded-2xl p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-600 text-sm font-medium">Total Belanja</p>
                            @php $totalSpent = \App\Models\Order::where('user_id', Auth::id())->sum('total'); @endphp
                            <p class="text-2xl font-bold text-slate-900 mt-2">Rp{{ number_format($totalSpent, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-500 mt-2">💰 Sepanjang waktu</p>
                        </div>
                        <div class="stat-icon gradient-success text-white">💰</div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- My Recent Orders -->
                <div class="lg:col-span-2">
                    <div class="glass-effect rounded-2xl p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-slate-900">📋 Pesanan Terbaru</h2>
                        </div>

                        <div class="overflow-x-auto">
                            @php
                                $myRecentOrders = \App\Models\Order::where('user_id', Auth::id())->latest()->limit(5)->get();
                            @endphp
                            @if($myRecentOrders->count() > 0)
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-slate-200">
                                            <th class="text-left py-2 px-2 font-semibold text-slate-700">ID</th>
                                            <th class="text-left py-2 px-2 font-semibold text-slate-700">Total</th>
                                            <th class="text-left py-2 px-2 font-semibold text-slate-700">Status</th>
                                            <th class="text-left py-2 px-2 font-semibold text-slate-700">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($myRecentOrders as $order)
                                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                                                <td class="py-2 px-2 text-slate-900 font-medium">#{{ $order->id }}</td>
                                                <td class="py-2 px-2 text-slate-900 font-semibold">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                                <td class="py-2 px-2">
                                                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                        @if($order->status === 'completed')
                                                            bg-green-100 text-green-800
                                                        @elseif($order->status === 'pending')
                                                            bg-yellow-100 text-yellow-800
                                                        @elseif($order->status === 'cancelled')
                                                            bg-red-100 text-red-800
                                                        @else
                                                            bg-blue-100 text-blue-800
                                                        @endif
                                                    ">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td class="py-2 px-2 text-slate-600">{{ $order->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-8">
                                    <p class="text-slate-500">Belum ada pesanan</p>
                                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-700 font-medium mt-2 inline-block">
                                        Mulai Belanja →
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="lg:col-span-1">
                    <div class="glass-effect rounded-2xl p-6 h-full">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">⚡ Aksi Cepat</h2>
                        <div class="space-y-3">
                            <a href="{{ route('products.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-slate-100 to-slate-50 hover:from-slate-200 hover:to-slate-100 transition">
                                <span class="text-xl">🛍️</span>
                                <span class="font-medium text-slate-900">Belanja</span>
                            </a>
                            <a href="{{ route('cart.index') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-slate-100 to-slate-50 hover:from-slate-200 hover:to-slate-100 transition">
                                <span class="text-xl">🛒</span>
                                <span class="font-medium text-slate-900">Keranjang</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-slate-100 to-slate-50 hover:from-slate-200 hover:to-slate-100 transition">
                                <span class="text-xl">⚙️</span>
                                <span class="font-medium text-slate-900">Pengaturan</span>
                            </a>
                            <a href="{{ route('home') }}" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-slate-100 to-slate-50 hover:from-slate-200 hover:to-slate-100 transition">
                                <span class="text-xl">🏪</span>
                                <span class="font-medium text-slate-900">Toko Utama</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Account Info -->
                <div class="glass-effect rounded-2xl p-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">👤 Informasi Akun</h2>
                    <div class="space-y-3 text-slate-600">
                        <div class="flex justify-between">
                            <span>Nama</span>
                            <span class="font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Email</span>
                            <span class="font-semibold text-slate-900">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Status</span>
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">✓ Aktif</span>
                        </div>
                        <div class="pt-3 border-t border-slate-200">
                            <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                Ubah Profil →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="glass-effect rounded-2xl p-6">
                    <h2 class="text-xl font-bold text-slate-900 mb-4">💡 Tips Penggunaan</h2>
                    <ul class="space-y-2 text-slate-600 text-sm">
                        <li class="flex items-start gap-2">
                            <span class="text-lg">✓</span>
                            <span>Pantau status pesanan Anda secara real-time</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-lg">✓</span>
                            <span>Simpan produk favorit untuk pembelian mudah</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-lg">✓</span>
                            <span>Gunakan wishlist untuk reminder pembelian</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-lg">✓</span>
                            <span>Hubungi kami jika ada pertanyaan</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
