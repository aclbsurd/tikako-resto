<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{

    public function index()
    {
        $menus = Menu::orderBy('id', 'desc')->paginate(10);        
        return view('admin.menu.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|integer',
            'kategori' => 'required|string',
            'deskripsi' => 'nullable|string',
            'is_tersedia' => 'required|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_rekomendasi' => 'required|boolean'
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('menu_fotos', 'public');
            $validatedData['foto'] = $path;
        }

        Menu::create($validatedData);

        return redirect()->route('menu.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validatedData = $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|integer',
            'kategori' => 'required|string',
            'deskripsi' => 'nullable|string',
            'is_tersedia' => 'required|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_rekomendasi' => 'required|boolean'
        ]);

        if ($request->hasFile('foto')) {
            if ($menu->foto) {
                Storage::disk('public')->delete($menu->foto);
            }
            $path = $request->file('foto')->store('menu_fotos', 'public');
            $validatedData['foto'] = $path; 
        }
        $menu->update($validatedData);
        return redirect()->route('menu.index')->with('success', 'Menu berhasil di-update!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->foto) {
            Storage::disk('public')->delete($menu->foto);
        }
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }

    public function toggleStatus(Request $request, \App\Models\Menu $menu)
    {
        $newStatus = $request->input('status'); 
        $menu->is_tersedia = $newStatus;
        $menu->save();
        return response()->json([
            'success' => true,
            'new_status' => $menu->is_tersedia,
            'message' => 'Status berhasil diubah menjadi ' . ($newStatus ? 'Tersedia' : 'Habis')
        ]);
    }
}