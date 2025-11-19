<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; 
use App\Models\Feedback; 

class CustomerMenuController extends Controller
{
    public function index()
    {
        $menu_rekomendasi = Menu::where('is_tersedia', true)
                                ->where('is_rekomendasi', true)
                                ->get();

        $menu_lainnya = Menu::where('is_tersedia', true)
                            ->where('is_rekomendasi', false)
                            ->orderBy('created_at', 'desc') 
                            ->take(6) 
                            ->get();

        return view('pelanggan.index', [
            'data_rekomendasi' => $menu_rekomendasi,
            'data_menu_lainnya' => $menu_lainnya
        ]);
    }

    public function menuPage(Request $request)
    {
        if ($request->has('meja')) {
            session(['nomor_meja' => $request->meja]);
        }

        $query = Menu::where('is_tersedia', true);

        if ($request->has('kategori') && $request->kategori != '') {
            
            $menus = Menu::where('is_tersedia', true)
                         ->where('kategori', $request->kategori)
                         ->orderBy('is_rekomendasi', 'desc')
                         ->orderBy('created_at', 'desc')  
                         ->paginate(10);
            return view('pelanggan.menu', [
                'menus' => $menus,
                'kategori_aktif' => $request->kategori,
                'mode_tampilan' => 'list'
            ]);
        } else {
            $menus = Menu::where('is_tersedia', true)
                         ->orderBy('is_rekomendasi', 'desc') 
                         ->orderBy('created_at', 'desc')
                         ->get()
                         ->groupBy('kategori'); 
            return view('pelanggan.menu', [
                'menus_grouped' => $menus, 
                'kategori_aktif' => '',
                'mode_tampilan' => 'group' 
            ]);
        }
    }

    public function show(Menu $menu)
    {
        if (!$menu->is_tersedia) {
            abort(404);
        }
        return view('pelanggan.show', [
            'menu' => $menu
        ]);
    }

    public function about()
    {
        return view('pelanggan.tentang');
    }

    public function contact()
    {
        return view('pelanggan.kontak');
    }

    public function storeFeedback(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255', 
            'rating' => 'required|integer|min:1|max:5', 
            'message' => 'required|string|min:5',
        ]);
        Feedback::create([
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'message' => $request->message,
        ]);
        return redirect()->back()->with('success', 'Terima kasih! Masukan Anda sangat berarti bagi kami.');
    }
}