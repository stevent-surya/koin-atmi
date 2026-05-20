<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceLog;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        // Hanya ambil yang statusnya ongoing
        $ongoingMaintenances = MaintenanceLog::with('item')->where('status', 'ongoing')->latest()->get();
        return view('maintenance.index', compact('ongoingMaintenances'));
    }
}