<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use HasFactory, LogsActivity;

    public static function boot()
    {
        parent::boot();

        static::creating(function($product) {
            $slug = $this->generateSlug($product->name);
            $product->slug = $slug;
        });

        static::updating(function($product) {
            $slug = static::generateSlug($product->name, $product->id);
            $product->slug = $slug;
        });

    }

    public static function generateSlug($product, $id = null): string
    {
        $slug = Str::slug($product);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'");
        if ($id){
            $count = $count->where('id', '!=', $id);
        }

        $count = $count->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }
    protected static $logName = 'Product';
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    protected static $ignoreChangedAttributes = ['updated_at'];

    protected $fillable = [ 'name', 'slug', 'description', 'price', 'qty', 'image' ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'price' => 'double'
    ];



}
