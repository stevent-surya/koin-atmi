<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\MaintenanceLog;
use App\Models\SuspendLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'borrow');

        // 1. Log Peminjaman Alat (Filter NIM/Nama/Alat)
        $borrowQuery = Borrowing::with(['user', 'item'])->latest();
        if ($request->filled('borrow_search')) {
            $search = $request->borrow_search;
            $borrowQuery->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('nim', 'like', "%$search%");
            })->orWhereHas('item', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }
        $borrowingLogs = $borrowQuery->paginate(20, ['*'], 'borrow_page')->appends(request()->query());

        // 2. Log Maintenance (Filter Nama Alat)
        $maintQuery = MaintenanceLog::with('item')->latest();
        if ($request->filled('maint_search')) {
            $maintQuery->whereHas('item', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->maint_search . '%');
            });
        }
        $maintenanceLogs = $maintQuery->paginate(20, ['*'], 'maint_page')->appends(request()->query());

        // 3. Log Suspend Akun (Filter Nama/NIM)
        $suspendQuery = SuspendLog::with(['user', 'admin'])->latest();
        if ($request->filled('suspend_search')) {
            $search = $request->suspend_search;
            $suspendQuery->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('nim', 'like', "%$search%");
            });
        }
        $suspendLogs = $suspendQuery->paginate(20, ['*'], 'suspend_page')->appends(request()->query());

        return view('logs.index', compact('borrowingLogs', 'maintenanceLogs', 'suspendLogs', 'activeTab'));
    }
}