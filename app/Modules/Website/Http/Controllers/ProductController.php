<?php

namespace App\Modules\Website\Http\Controllers;

use App\Modules\Products\Contracts\ProductCatalogInterface;
use Illuminate\View\View;

class ProductController
{
    /**
     * Display the product listing page.
     */
    public function index(ProductCatalogInterface $catalog): View
    {
        $products = $catalog->getPublishedProducts();
        $categories = $catalog->getCategories();
        $categoriesMap = $categories->pluck('name', 'id')->toArray();

        return view('website.products.index', [
            'products' => $products,
            'categoriesMap' => $categoriesMap,
        ]);
    }

    /**
     * Display the product detail page.
     */
    public function show(string $slug, ProductCatalogInterface $catalog): View
    {
        $product = $catalog->getProductBySlug($slug);

        if (!$product) {
            abort(404);
        }

        $categories = $catalog->getCategories();
        $category = $categories->firstWhere('id', $product['category_id']);

        return view('website.products.show', [
            'product' => $product,
            'category' => $category,
        ]);
    }
}