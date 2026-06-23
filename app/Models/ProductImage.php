<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image_path', 'is_primary'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Returns a working URL whether image_path is an external URL or a local storage path.
     */
    public function getUrlAttribute(): string
    {
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }
        return \Illuminate\Support\Facades\Storage::url($this->image_path);
    }
}
