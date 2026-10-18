<?php

namespace App\Modules\Products\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Category;
use App\Modules\Products\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')
            ->latest('id')
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (!filled($request->input('slug'))) {
            $request->merge(['slug' => Str::slug($request->input('title', ''))]);
        }

        $validated = $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:products_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', 'unique:products,slug'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'full_description' => ['nullable', 'string'],
            'specs' => ['nullable', 'array'],
            'specs.*.key' => ['nullable', 'string', 'max:255'],
            'specs.*.value' => ['nullable', 'string', 'max:1000'],
            'specs.*.unit' => ['nullable', 'string', 'max:100'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'string', 'max:2048'],
            'image_uploads' => ['nullable', 'array'],
            'image_uploads.*' => ['image', 'max:5120'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?: 'product-' . Str::lower(Str::random(8));
        $validated['is_published'] = $request->boolean('is_published');
        $validated['specs'] = $this->normalizeSpecs($validated['specs'] ?? []);

        $images = collect($validated['images'] ?? [])
            ->filter(fn ($image) => filled($image))
            ->map(fn ($image) => trim($image))
            ->values();

        foreach ($request->file('image_uploads', []) as $image) {
            $images->push($image->store('products', 'public'));
        }

        $validated['images'] = $images->all();
        unset($validated['image_uploads']);

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'محصول با موفقیت ثبت شد.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        if (!filled($request->input('slug'))) {
            $request->merge(['slug' => Str::slug($request->input('title', ''))]);
        }

        $validated = $request->validate([
            'category_id' => ['nullable', 'integer', 'exists:products_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable', 'string', 'max:255', 'alpha_dash',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'full_description' => ['nullable', 'string'],
            'specs' => ['nullable', 'array'],
            'specs.*.key' => ['nullable', 'string', 'max:255'],
            'specs.*.value' => ['nullable', 'string', 'max:1000'],
            'specs.*.unit' => ['nullable', 'string', 'max:100'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'string', 'max:2048'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['string', 'max:2048'],
            'image_uploads' => ['nullable', 'array'],
            'image_uploads.*' => ['image', 'max:5120'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?: 'product-' . Str::lower(Str::random(8));
        $validated['is_published'] = $request->boolean('is_published');
        $validated['specs'] = $this->normalizeSpecs($validated['specs'] ?? []);

        $removedImages = $validated['remove_images'] ?? [];

        // فقط تصاویر متعلق به همین محصول نگه داشته می‌شوند.
        $currentImages = collect($product->images ?? []);
        $submittedImages = collect($validated['images'] ?? []);

        $images = $submittedImages
            ->intersect($currentImages)
            ->reject(fn ($image) => in_array($image, $removedImages, true))
            ->values();

        foreach ($request->file('image_uploads', []) as $image) {
            $images->push($image->store('products', 'public'));
        }

        $validated['images'] = $images->unique()->values()->all();
        unset($validated['image_uploads'], $validated['remove_images']);

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'تغییرات محصول با موفقیت ذخیره شد.');
    }

    private function normalizeSpecs(array $specs): array
    {
        return collect($specs)
            ->filter(fn ($spec) => filled($spec['key'] ?? null))
            ->map(fn ($spec) => [
                'key' => trim($spec['key']),
                'value' => trim($spec['value'] ?? ''),
                'unit' => trim($spec['unit'] ?? ''),
            ])
            ->values()
            ->all();
    }
}