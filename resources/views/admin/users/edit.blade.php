<x-app-layout>
  <style>
    .glass-effect {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }
  </style>

  <div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
      <!-- Header -->
      <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold mb-4 inline-block">
          ← Kembali ke Daftar User
        </a>
        <h1 class="text-4xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">
          ✎ Edit User
        </h1>
        <p class="text-slate-600 mt-2">Ubah role dan status user</p>
      </div>

      <!-- Edit Form -->
      <div class="glass-effect rounded-2xl p-8">
        <form action="{{ route('admin.users.update', $user) }}" method="post" class="space-y-6">
          @csrf
          @method('PATCH')

          <!-- User Info (Read-only) -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-slate-200">
            <div>
              <label class="block font-semibold text-slate-900 mb-2">Nama</label>
              <input type="text" value="{{ $user->name }}" disabled class="w-full border-2 border-slate-300 rounded-lg px-4 py-3 bg-slate-100 text-slate-600">
            </div>
            <div>
              <label class="block font-semibold text-slate-900 mb-2">Email</label>
              <input type="email" value="{{ $user->email }}" disabled class="w-full border-2 border-slate-300 rounded-lg px-4 py-3 bg-slate-100 text-slate-600">
            </div>
          </div>

          <!-- Role Selection -->
          <div>
            <label class="block font-semibold text-slate-900 mb-3">👤 Role</label>
            <div class="space-y-3">
              <label class="flex items-center p-4 border-2 border-slate-300 rounded-lg cursor-pointer hover:border-blue-500 transition"
                @if(old('role', $user->role) === 'user') :class="{ 'border-blue-500 bg-blue-50': true }" @endif>
                <input type="radio" name="role" value="user" {{ old('role', $user->role) === 'user' ? 'checked' : '' }} class="mr-3">
                <div>
                  <p class="font-semibold text-slate-900">User</p>
                  <p class="text-sm text-slate-600">Pelanggan biasa, akses terbatas ke toko</p>
                </div>
              </label>

              <label class="flex items-center p-4 border-2 border-slate-300 rounded-lg cursor-pointer hover:border-blue-500 transition"
                @if(old('role', $user->role) === 'admin') :class="{ 'border-blue-500 bg-blue-50': true }" @endif>
                <input type="radio" name="role" value="admin" {{ old('role', $user->role) === 'admin' ? 'checked' : '' }} class="mr-3">
                <div>
                  <p class="font-semibold text-slate-900">Admin</p>
                  <p class="text-sm text-slate-600">Akses penuh ke panel admin untuk mengelola toko</p>
                </div>
              </label>
            </div>
            @error('role')
              <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
          </div>

          <!-- Status Selection -->
          <div>
            <label class="block font-semibold text-slate-900 mb-3">⊙ Status</label>
            <div class="space-y-3">
              <label class="flex items-center p-4 border-2 border-slate-300 rounded-lg cursor-pointer hover:border-blue-500 transition"
                @if(old('is_active', $user->is_active) == true) :class="{ 'border-blue-500 bg-blue-50': true }" @endif>
                <input type="radio" name="is_active" value="1" {{ old('is_active', $user->is_active) == true ? 'checked' : '' }} class="mr-3">
                <div>
                  <p class="font-semibold text-slate-900">✓ Aktif</p>
                  <p class="text-sm text-slate-600">User dapat menggunakan akun mereka</p>
                </div>
              </label>

              <label class="flex items-center p-4 border-2 border-slate-300 rounded-lg cursor-pointer hover:border-blue-500 transition"
                @if(old('is_active', $user->is_active) == false) :class="{ 'border-blue-500 bg-blue-50': true }" @endif>
                <input type="radio" name="is_active" value="0" {{ old('is_active', $user->is_active) == false ? 'checked' : '' }} class="mr-3">
                <div>
                  <p class="font-semibold text-slate-900">✕ Nonaktif</p>
                  <p class="text-sm text-slate-600">User tidak dapat menggunakan akun mereka</p>
                </div>
              </label>
            </div>
            @error('is_active')
              <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
          </div>

          <!-- Buttons -->
          <div class="flex gap-4 pt-6 border-t border-slate-200">
            <button type="submit" class="flex-1 px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg font-bold hover:from-blue-600 hover:to-blue-700 transition">
              ✓ Simpan Perubahan
            </button>
            <a href="{{ route('admin.users.index') }}" class="flex-1 px-6 py-4 border-2 border-slate-300 text-slate-900 rounded-lg font-bold hover:bg-slate-50 transition text-center">
              Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
