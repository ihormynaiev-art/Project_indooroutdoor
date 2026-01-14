<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return DataTables::of(Category::query()->with('parent'))->make();
        }

        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = Category::where('is_active', true)->whereNull('parent_id')->get();

        return view('admin.categories.create', [
            'parentCategories' => $parentCategories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        if ($request->has('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('categoryImages', 'public');
        }

        Category::query()
            ->create([
                'name' => $request->name,
                'slug' => $request->slug,
                'prio' => $request->prio,
                'parent_id' => $request->parent_id,
                'is_active' => boolval($request->is_active),
                'show_in_home_top_slider' => boolval($request->show_in_home_top_slider),
                'image_path' => $imagePath ?? '',
                'icon_path' => '',
            ]);

        return to_route('admin.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->whereNot('id', $category->id)
            ->get();

        return view('admin.categories.edit', [
            'category' => $category,
            'parentCategories' => $parentCategories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $image = $request->file('image');
        if ($image) {
            $imagePath = $image->store('categoryImages', 'public');
            $category->image_path = $imagePath;
        }

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->prio = $request->prio;
        $category->is_active = boolval($request->is_active);
        $category->is_license_required = boolval($request->is_license_required);
        $category->show_in_home_top_slider = boolval($request->show_in_home_top_slider);
        $category->parent_id = $request->parent_id;
        $category->save();

        return to_route('admin.categories.index');
    }

    public function updateIsActive(Request $request, $id)
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ]);
        }

        $category->update([
            'is_active' => filter_var($request->input('is_active'), FILTER_VALIDATE_BOOLEAN),
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function updateShowInHomeTopSlider(Request $request, $id)
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ]);
        }

        $category->update([
            'show_in_home_top_slider' => filter_var($request->input('show_in_home_top_slider'), FILTER_VALIDATE_BOOLEAN),
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['status' => 'success']);
    }

    public function getSubCategories(Request $request)
    {
        $subCategories = Category::whereIn('parent_id', $request->input('categoriesIds', []))->get();

        return response()->json([
            'status' => 'success',
            'data' => $subCategories,
        ]);
    }

    public function getSubCategoriesByCategoriesArr(Request $request)
    {
        $query = Category::whereNotNull('parent_id')->where('is_active', true);

        if ($request->has('categories')) {
            $query->whereHas('parent', function ($q) use ($request) {
                $q->whereIn('slug', $request->input('categories'));
            });
        }

        return response()->json([
            'status' => 'success',
            'data' => $query->get(['name', 'id']),
        ]);
    }
}
