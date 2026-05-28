<?php

namespace App\Http\Controllers\Api\Blog\Admin;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginator = BlogCategory::paginate(5);

        return $paginator;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_categories,slug'],
            'parent_id' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = $this->makeUniqueSlug($data['title']);
        }

        $data['parent_id'] = $data['parent_id'] ?? 1;

        $item = BlogCategory::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Успішно створено',
            'data' => $item,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = BlogCategory::find($id);
        if (empty($item)) {
            return ['message' => "Запис id=[{$id}] не знайдено"];
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:blog_categories,slug,'.$id],
            'parent_id' => ['nullable', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = $this->makeUniqueSlug($data['title'], $item->id);
        }

        $result = $item->update($data);

        if ($result) {
            return [
                'success' => true,
                'message' => 'Успішно збережено',
                'data' => $item->fresh(),
            ];
        }

        return ['message' => 'Помилка збереження'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $slug = $slug !== '' ? $slug : 'category';
        $baseSlug = $slug;
        $counter = 1;

        while (
            BlogCategory::query()
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
