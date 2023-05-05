<?php

namespace App\Models;

use App\Models\Expenses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Batch extends Model
{
    use HasFactory;
    protected $fillable = [
        'batchNo',
        'cycle',
        'dateStarted',
        'expenses_id',
        'endDate',
        'totalDays'
    ];

    public function expenses()
    {
        return $this->hasMany(Expenses::class);
    }
}
