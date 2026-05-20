<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('items.index');
        }

        $borrowings = Borrowing::with('item')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('dashboard', compact('borrowings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'qty' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $item = Item::findOrFail($request->item_id);

        // Cek Suspended
        if ($user->is_suspended) {
            return back()->with('error', 'Akun Anda dalam status suspend! Anda tidak dapat meminjam alat.');
        }

        // Cek Maintenance
        if ($item->is_maintenance) {
            return back()->with('error', 'Alat sedang dalam maintenance! Tidak dapat dipinjam.');
        }

        $qty = $request->qty;
        $totalCost = $item->coin_cost * $qty; // Akan selalu 1 * qty

        if ($user->coins < $totalCost) {
            return back()->with('error', 'Koin Anda tidak cukup! Anda memiliki ' . $user->coins . ' koin, butuh ' . $totalCost . ' koin.');
        }

        if ($item->stock < $qty) {
            return back()->with('error', 'Stok alat tidak cukup! Tersedia: ' . $item->stock);
        }

        DB::transaction(function () use ($user, $item, $qty, $totalCost) {
            $user->decrement('coins', $totalCost);
            $item->decrement('stock', $qty);

            Borrowing::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'qty' => $qty,
                'status' => 'borrowed',
                'borrowed_at' => now(),
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Alat berhasil dipinjam!');
    }

    public function returnItem(Borrowing $borrowing)
    {
        if ($borrowing->user_id !== Auth::id() || $borrowing->status === 'returned') {
            abort(403);
        }

        $user = Auth::user();
        $item = $borrowing->item;
        $refundCoins = $item->coin_cost * $borrowing->qty;

        DB::transaction(function () use ($user, $item, $borrowing, $refundCoins) {
            $item->increment('stock', $borrowing->qty);
            $borrowing->update(['status' => 'returned', 'returned_at' => now()]);
            $newCoins = $user->coins + $refundCoins;
            $user->update(['coins' => min($newCoins, 10)]);
        });

        return redirect()->route('dashboard')->with('success', 'Alat berhasil dikembalikan dan koin dikembalikan!');
    }
}