<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'stock',
        'coin_cost',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }

    // Helper untuk cek apakah sedang maintenance
    public function isUnderMaintenance()
    {
        return $this->maintenanceLogs()->where('status', 'ongoing')->exists();
    }
}