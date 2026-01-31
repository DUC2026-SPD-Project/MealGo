<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Optional: if you used softDeletes in migration

class Product extends Model
{
    use HasFactory;

    // 1. Allow these fields to be filled by forms/seeders
    protected $fillable = [
        'category_id',
        'supplier_id',
        'name_en',
        'name_kh',
        'barcode',
        'cost_price',
        'sale_price',
        'qty',
        'alert_qty',
        'image',
        'status',
        'description'
    ];

    // Add image URL accessor
    protected $appends = ['image_url'];

    // 2. Define Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function saleItems()
    {
        return $this->hasMany(\App\Models\SaleItem::class);
    }

    // 3. Image URL Accessor - Enhanced for better debugging
    public function getImageUrlAttribute()
    {
        // If no image, return default
        if (!$this->image) {
            return asset('images/no-image.svg');
        }
        
        // If image already has full URL (starts with http), return as is
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        
        // If image already has /storage/ prefix, return with asset helper
        if (str_starts_with($this->image, '/storage/')) {
            return asset($this->image);
        }
        
        // If image starts with storage/ (without leading slash), add asset
        if (str_starts_with($this->image, 'storage/')) {
            return asset('/' . $this->image);
        }
        
        // For products stored as 'products/filename.ext', prepend /storage/
        return asset('/storage/' . $this->image);
    }

    // 4. Scope for active products
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // 5. Scope for in stock products
    public function scopeInStock($query)
    {
        return $query->where('qty', '>', 0);
    }
}