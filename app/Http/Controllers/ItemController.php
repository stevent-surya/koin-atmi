<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MaintenanceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        // Logic Search Katalog
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        $items = $query->get();
        return view('items.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:items,code',
            'stock' => 'required|integer|min:0',
        ]);

        Item::create([
            'name' => $request->name,
            'code' => $request->code,
            'stock' => $request->stock,
            'coin_cost' => 1, 
        ]);

        return redirect()->route('items.index')->with('success', 'Alat berhasil ditambahkan!');
    }

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

    public function startMaintenance(Request $request, Item $item)
    {
        $request->validate([
            'qty' => 'required|integer|min:1|max:' . $item->stock,
            'reason' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $item) {
            $item->decrement('stock', $request->qty);
            MaintenanceLog::create([
                'item_id' => $item->id,
                'qty' => $request->qty,
                'reason' => $request->reason,
                'location' => $request->location,
                'status' => 'ongoing',
            ]);
        });

        return back()->with('success', 'Alat berhasil dimasukkan ke maintenance.');
    }

    public function finishMaintenance(MaintenanceLog $maintenanceLog)
    {
        DB::transaction(function () use ($maintenanceLog) {
            $maintenanceLog->item->increment('stock', $maintenanceLog->qty);
            $maintenanceLog->update(['status' => 'completed']);
        });

        return back()->with('success', 'Maintenance selesai, stok alat telah dikembalikan.');
    }
}