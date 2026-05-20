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
}