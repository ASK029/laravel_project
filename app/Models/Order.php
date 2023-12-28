<?php

namespace App\Models;

use App\Models\Med;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'med_id',
        'user_id',
        'quantity_required',
        'status',
        'paid'
    ];

    public function med()
    {
        return $this->belongsTo(Med::class);
    }
}
