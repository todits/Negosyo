<?php

namespace App\Models;

use App\Models\Batch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expenses extends Model
{
    use HasFactory;
    protected $fillable = [
        'item',
        'price',
        'quantity',
        'total',
        'datepurchase',
        'batch_id'

    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
