<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'qty',
        'status',
        'borrowed_at',
        'returned_at',
    ];

    protected function casts(): array
    {
        return [
            'borrowed_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}