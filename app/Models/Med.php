<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class,'orders')->withPivot('quantity');
    }
}
