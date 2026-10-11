<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Contracts\ProductCatalogInterface;
use App\Modules\Products\Models\Category;
use App\Modules\Products\Models\Product;
use Illuminate\Support\Collection;

class ProductCatalogService implements ProductCatalogInterface
{
    /**
     * Get all published products.
     *
     * @return Collection<int, array>
     */
    public function getPublishedProducts(): Collection
    {
        return Product::published()
            ->orderBy('title')
            ->get()
            ->map(fn (Product $product) => [
                'id' => $product->id,
                'category_id' => $product->category_id,
                'title' => $product->title,
                'slug' => $product->slug,
                'short_description' => $product->short_description,
                'images' => $product->images ?? [],
            ]);
    }

    /**
     * Get a single product by its slug.
     *
     * @param string $slug
     * @return array|null
     */
    public function getProductBySlug(string $slug): ?array
    {
        $product = Product::published()
            ->where('slug', $slug)
            ->first();

        if (!$product) {
            return null;
        }

        return [
            'id' => $product->id,
            'category_id' => $product->category_id,
            'title' => $product->title,
            'slug' => $product->slug,
            'short_description' => $product->short_description,
            'full_description' => $product->full_description,
            'specs' => $product->specs ?? [],
            'meta_title' => $product->meta_title,
            'meta_description' => $product->meta_description,
            'images' => $product->images ?? [],
        ];
    }

    /**
     * Get all product categories.
     *
     * @return Collection<int, array>
     */
    public function getCategories(): Collection
    {
        return Category::ordered()
            ->get()
            ->map(fn (Category $category) => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
            ]);
    }
}