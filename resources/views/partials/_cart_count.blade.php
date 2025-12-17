@php
$cartCount = 0;
if (Auth::check()) {
    $cart = \App\Models\Cart::firstOrCreate(['user_id' => Auth::id()]);
    $cartCount = $cart->items()->sum('qty');
}
@endphp

@if($cartCount > 0)
    <span class="ml-auto bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1">{{ $cartCount }}</span>
@endif
