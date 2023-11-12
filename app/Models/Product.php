<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'url',
        'title',
        'price',
        'promo',
        'shippingcost',
        'brand',
        'reference',
        'mpn',
        'ean',
        'imageurl',
        'available',
        'description',
        'spec',
        'config_id',
    ];

    public function config(): BelongsTo
    { 
        return $this->belongsTo(Config::class);
    }
}
