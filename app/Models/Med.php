<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Med extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'scientific_name',
        'commercial_name',
        'category',
        'manufacturer_name',
        'price',
        'expiration_date',
        'quantity_available'
    ];

    public function toSearchableArray()
    {
        return [
            'commercial_name' => $this->commercial_name,
            'category' => $this->category
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
