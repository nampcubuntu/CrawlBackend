<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Config extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'productconfigurationurl',
        'url',
        'sitemapurl',
        'sitemaplevel1xpath',
        'sitemaplevel2xpath',
        'sitemaplevel3xpath',
        'sitemapsubcategoryxpath',
        'productxpath',
        'paginationxpath',
        'textareaHookcode',
        'producttitlexpath',
        'productpricexpath',
        'productdiscountpricexpath',
        'productbrandxpath',
        'productreferencexpath',
        'productmpnxpath',
        'producteanxpath',
        'productimageurlxpath',
        'productdescriptionxpath',
        'agentHookcode',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
