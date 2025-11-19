<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 
use Illuminate\Support\Facades\Auth; 
use App\Models\Order;
use App\Models\CartItem;

class OrderController extends Controller
{
    public function success()
    {
        $orderId = Session::get('orderId');

        if (!$orderId) {
            return redirect('/');
        }

        return view('order.success', [
            'orderId' => $orderId
        ]);
    }

    public function myOrders()
    {
        $userId = Auth::id(); 

        if (!$userId) {
            return redirect()->route('login');
        }

        $orders = Order::with('details.menu')
                       ->where('user_id', $userId)
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('pelanggan.pesanan', [
            'orders' => $orders
        ]);
    }

    public function repeatOrder(Order $order)
    {
        $userId = Auth::id();

        if ($order->user_id !== $userId) {
            return redirect()->route('orders.myOrders')->with('error', 'Aksi tidak diizinkan.');
        }

        $warning = []; 

        foreach ($order->details as $detail) {
            
            $menu = $detail->menu;

            if (!$menu || !$menu->is_tersedia) {
                $warning[] = $detail->menu->nama_menu; 
                continue; 
            }

            $cartItem = CartItem::where('user_id', $userId)
                                ->where('menu_id', $detail->menu_id)
                                ->first();

            if ($cartItem) {
                $cartItem->quantity += $detail->quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id' => $userId,
                    'menu_id' => $detail->menu_id,
                    'quantity' => $detail->quantity,
                ]);
            }
        }
        
        $message = 'Pesanan #' . $order->id . ' berhasil ditambahkan ke keranjang Anda!';
        if (!empty($warning)) {
            $message .= ' Namun, menu berikut tidak ditambahkan karena stok habis: ' . implode(', ', $warning) . '.';
        }

        return redirect()->route('cart.index')->with('success', $message);
    }
    public function profile()
    {
        $user = Auth::user(); 

        return view('pelanggan.profile', [
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id, // Email harus unik, tapi abaikan email user saat ini
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
}