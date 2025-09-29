<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Category::class);
        $categories=Category::where('school_id',Auth::user()->school_id)->get();
        return view('school_admin.categories.index',compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Category::class);
        return view('school_admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);
        $data=$request->validate([
            'name'=>'required|string|max:255|unique:categories,name',
        ]);
        $school_id=auth()->user()->school_id;
        $data['school_id']=$school_id;
        Category::create($data);
        return redirect()->route('categories.index')->with('success','تم إضافة الفئة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);
        $data=$request->validate([
            'name'=>'required|string|max:255|unique:categories,name,'.$category->id,
        ]);
        $category->update($data);
        return redirect()->route('categories.index')->with('success','تم تحديث الفئة بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();
        return redirect()->route('categories.index')->with('success','تم حذف الفئة بنجاح');

    }
}
