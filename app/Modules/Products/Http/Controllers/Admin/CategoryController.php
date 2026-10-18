<?php

namespace App\Modules\Products\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::with('parent')
            ->withCount('products')
            ->ordered()
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $categories = Category::ordered()->get();

        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash', Rule::unique('products_categories', 'slug')],
            'parent_id' => ['nullable', 'integer', 'exists:products_categories,id'],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['slug'] = $this->makeSlug($validated['slug'] ?? $validated['name']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'دسته‌بندی با موفقیت ثبت شد.');
    }

    public function edit(Category $category): View
    {
        $categories = Category::where('id', '!=', $category->id)
            ->ordered()
            ->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('products_categories', 'slug')->ignore($category->id),
            ],
            'parent_id' => [
                'nullable',
                'integer',
                'exists:products_categories,id',
                Rule::notIn([$category->id]),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['slug'] = $this->makeSlug($validated['slug'] ?? $validated['name']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'دسته‌بندی با موفقیت ویرایش شد.');
    }

    public function duplicate(Category $category): RedirectResponse
    {
        $copy = DB::transaction(function () use ($category) {
            $name = $category->name . ' - کپی';
            $baseSlug = Str::slug($category->slug ?: $category->name) . '-copy';
            $slug = $baseSlug;
            $suffix = 2;

            while (Category::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $suffix++;
            }

            return Category::create([
                'name' => $name,
                'slug' => $slug,
                'parent_id' => $category->parent_id,
                'description' => $category->description,
                'sort_order' => $category->sort_order,
            ]);
        });

        return redirect()->route('admin.categories.edit', $copy)
            ->with('success', 'نسخه جدید ساخته شد؛ می‌توانی اطلاعات آن را ویرایش کنی.');
    }

    private function makeSlug(string $value): string
    {
        $slug = Str::slug($value);

        return $slug !== '' ? $slug : 'category-' . Str::lower(Str::random(8));
    }
}
