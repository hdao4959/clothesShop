<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     const PATH_VIEW = 'admin.categories.';
    public function index()
    {
        $categories = Category::latest('id')->paginate(5);
        return view(self::PATH_VIEW . __FUNCTION__, compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $request['is_active'] ??= 0;
        $data = [
            'name' => $request->name,
            'is_active' => $request['is_active'],
            'created_at' => now(),
            'updated_at' => now()
        ];
        Category::create($data);
           return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

        return view(self::PATH_VIEW . __FUNCTION__);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
            return view(self::PATH_VIEW . __FUNCTION__, compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {   
        $request['is_active'] ??= 0;
        $data = [
            'name' => $request->name,
            'is_active' =>$request['is_active'],
            'updated_at' => now()
        ];
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', "Cập nhật dữ liệu thành công");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', "Xoá danh mục thành công");
    }
}
