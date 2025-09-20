<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLayerRequest;
use App\Http\Requests\UpdateLayerRequest;
use App\Models\Category;
use App\Models\Layer;
use Illuminate\Http\Request;

class LayersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $this->authorize('viewAny', Layer::class);
        $user = auth()->user();
        if ($user->school_id !== $category->school_id) {
            return redirect()->route('home')->with('error', 'لا يمكنك الوصول إلى هذه الصفحة.');
        }
        $layers = $category->layers()->get();

        return view('school_admin.layers.index',compact('category','layers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        $this->authorize('create', Layer::class);
        return view('school_admin.layers.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLayerRequest $request,Category $category)
    {
        $this->authorize('create', Layer::class);
        $validated = $request->validated();
        $category->layers()->create($validated);
        return redirect()->route('categories.layers.index',$category)->with('success', 'تم إضافة الطبقة بنجاح.');
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
    public function update(UpdateLayerRequest $request, Category $category, Layer $layer)
    {
        $this->authorize('update', $layer);
        $validated = $request->validated();
        $layer->update($validated);
        return redirect()->route('categories.layers.index',$category)->with('success', 'تم تحديث الطبقة بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, Layer $layer)
    {
        $this->authorize('delete', $layer);
        $layer->delete();
        return redirect()->route('categories.layers.index',$category)->with('success', 'تم حذف الطبقة بنجاح.');
    }
}
