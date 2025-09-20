<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLevelRequest;
use App\Http\Requests\UpdateLevelRequest;
use App\Models\Category;
use App\Models\Layer;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category, Layer $layer)
    {
        $this->authorize('viewAny', Level::class);
        $user = auth()->user();
        if ($user->school_id !== $category->school_id||$user->school_id !== $layer->category->school_id) {
            return redirect()->route('home')->with('error', 'لا يمكنك الوصول إلى هذه الصفحة.');
        }
        $levels = $layer->levels()->get();

        return view('school_admin.levels.index',compact('category','layer','levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category, Layer $layer)
    {
        $this->authorize('create', Level::class);
        return view('school_admin.levels.create',compact('category','layer'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLevelRequest $request,Category $category, Layer $layer)
    {
        $this->authorize('create', Level::class);
        $validated = $request->validated();
        $layer->levels()->create($validated);
        return redirect()->route('categories.layers.levels.index',[$category,$layer])->with('success', 'تم إضافة المستوى بنجاح.');
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
    public function update(UpdateLevelRequest $request, Category $category, Layer $layer, Level $level)
    {
        $this->authorize('update', $level);
        $validated = $request->validated();
        $level->update($validated);
        return redirect()->route('categories.layers.levels.index',[$category,$layer])->with('success', 'تم تحديث المستوى بنجاح.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, Layer $layer, Level $level)
    {
        $this->authorize('delete', $level);
        $level->delete();
        return redirect()->route('categories.layers.levels.index',[$category,$layer])->with('success', 'تم حذف المستوى بنجاح.');
    }
}
