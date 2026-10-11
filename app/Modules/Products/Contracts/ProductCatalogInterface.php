<?php

namespace App\Modules\Products\Contracts;

use Illuminate\Support\Collection;

interface ProductCatalogInterface
{
    /**
     * Get all published products.
     *
     * @return Collection<int, array{id: int, category_id: int, title: string, slug: string, short_description: string, images: array}>
     */
    public function getPublishedProducts(): Collection;

    /**
     * Get a single product by its slug.
     *
     * @param string $slug
     * @return array{id: int, category_id: int, title: string, slug: string, short_description: string, full_description: string, specs: array, meta_title: ?string, meta_description: ?string, images: array}|null
     */
    public function getProductBySlug(string $slug): ?array;

    /**
     * Get all product categories.
     *
     * @return Collection<int, array{id: int, name: string, slug: string, description: ?string}>
     */
    public function getCategories(): Collection;
}