<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'url',
        'title',
        'price',
        'promo',
        'shippingcost',
        'reference',
        'mpn',
        'ean',
        'available',
        'spec',
        'config_id',
    ];
}
