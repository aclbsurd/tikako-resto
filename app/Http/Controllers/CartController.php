<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem; 
use App\Models\Menu; 
use App\Models\Order; 
use App\Models\OrderDetail; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; 
use Illuminate\Support\Facades\Storage; 

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); 
        if (!$userId) { return redirect()->route('login'); }
        $cartItems = CartItem::with('menu')
                            ->where('user_id', $userId)
                            ->get();

        return view('cart.index', [
            'cartItems' => $cartItems
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menu,id', 
            'quantity' => 'required|integer|min:1' 
        ]);
        $userId = Auth::id();
        if (!$userId) { return redirect()->route('login'); }
        $menu = Menu::find($request->menu_id); 
        if (!$menu || !$menu->is_tersedia) {
            return redirect()->back()->with('error', 'Maaf, menu ini sedang tidak tersedia.');
        }
        $cartItem = CartItem::where('user_id', $userId)
                            ->where('menu_id', $request->menu_id)
                            ->first(); 
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $userId, 
                'menu_id' => $request->menu_id,
                'quantity' => $request->quantity
            ]);
        }
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan!');
        }
        $cartItem->delete();
        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|string|max:50'
        ]);

        $userId = Auth::id();
        if (!$userId) { return redirect()->route('login'); } 
        $cartItems = CartItem::with('menu')
                            ->where('user_id', $userId)
                            ->get();
        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang Anda kosong!');
        }
        foreach ($cartItems as $item) {
            if (!$item->menu || !$item->menu->is_tersedia) {
                return redirect()->route('cart.index')->with('error', 'Maaf, item "' . $item->menu->nama_menu . '" baru saja habis dan dihapus dari keranjang Anda.');
            }
        }
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->menu->harga * $item->quantity;
        }
        $order = Order::create([
            'user_id' => $userId, 
            'nomor_meja' => $request->nomor_meja,
            'total_price' => $totalPrice,
            'status' => 'Diterima' 
        ]);
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id, 
                'menu_id' => $item->menu_id,
                'quantity' => $item->quantity,
                'price' => $item->menu->harga 
            ]);
        }
        CartItem::where('user_id', $userId)->delete();
        return redirect()->route('order.success')->with('orderId', $order->id);
    }
}