<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'full_description',
        'specs',
        'images',
        'meta_title',
        'meta_description',
        'is_published',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'specs' => 'array',
        'images' => 'array',
        'is_published' => 'boolean',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Scope to get only published products.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to filter by category.
     */
    public function scopeInCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Get the effective meta title (fallback to title).
     */
    public function getEffectiveMetaTitleAttribute(): string
    {
        return $this->meta_title ?? $this->title;
    }

    /**
     * Get the effective meta description (fallback to short_description).
     */
    public function getEffectiveMetaDescriptionAttribute(): ?string
    {
        return $this->meta_description ?? $this->short_description;
    }
}