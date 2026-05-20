<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    // HAPUS FUNGSI CREATE() DAN STORE() LAMA, GANTI DENGAN INI:
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:items,code',
            'stock' => 'required|integer|min:0',
        ]);

        // Coin cost di-fix kan menjadi 1
        Item::create([
            'name' => $request->name,
            'code' => $request->code,
            'stock' => $request->stock,
            'coin_cost' => 1, 
            'is_maintenance' => false,
        ]);

        return redirect()->route('items.index')->with('success', 'Alat berhasil ditambahkan!');
    }

    // FUNGSI BARU UNTUK EDIT ALAT
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:items,code,' . $item->id,
            'stock' => 'required|integer|min:0',
        ]);

        $item->update([
            'name' => $request->name,
            'code' => $request->code,
            'stock' => $request->stock,
        ]);

        return redirect()->route('items.index')->with('success', 'Alat berhasil diperbarui!');
    }

    // FUNGSI BARU UNTUK TOGGLE MAINTENANCE
    public function toggleMaintenance(Item $item)
    {
        $item->update([
            'is_maintenance' => !$item->is_maintenance
        ]);

        $status = $item->is_maintenance ? 'dalam maintenance' : 'berfungsi normal';
        return back()->with('success', "Status alat berhasil diubah menjadi {$status}.");
    }
}