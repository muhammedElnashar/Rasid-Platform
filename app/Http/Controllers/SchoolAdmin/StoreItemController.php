<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAwardRequest;
use App\Http\Requests\UpdateAwardRequest;
use App\Models\RedemptionRequest;
use App\Models\Role;
use App\Models\StoreItem;
use App\Services\RedemptionRequestServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view-any', StoreItem::class);
        $schoolId=Auth::user()->school_id;
        $awards = StoreItem::with(['role','level'])->where('school_id',$schoolId)->get();
        return view('school_admin.store-items.index',compact('awards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', StoreItem::class);
        $roles = Role::ExpectModeratorAndAdmin()->get();
        $school = Auth::user()->school;
        $levels = $school->categories()
            ->with('layers.levels') // نجيب المستويات مع كل طبقة
            ->get()
            ->flatMap(function ($category) {
                return $category->layers->flatMap(function ($layer) use ($category) {
                    return $layer->levels->map(function ($level) use ($category, $layer) {
                        return(object) [
                            'id' => $level->id,
                            'name' => $level->name,
                            'layer' => $layer->name,
                            'category' => $category->name,
                        ];
                    });
                });
            });

        return view('school_admin.store-items.create',compact('roles','levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAwardRequest $request)
    {
        $this->authorize('create', StoreItem::class);
        $validated = $request->validated();
        $school=Auth::user()->school;
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('awards', 'images');

            $validated['image_url'] = $imagePath;
        }
        $validated['school_id']=$school->id;
        StoreItem::create($validated);
        return to_route('awards.index')->with('success','تم انشاء الجائزة بنجاح');


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
    public function edit(StoreItem $award)
    {
        $this->authorize('update', $award);
        $roles = Role::ExpectModeratorAndAdmin()->get();
        $school = Auth::user()->school;
        $levels = $school->categories()
            ->with('layers.levels') // نجيب المستويات مع كل طبقة
            ->get()
            ->flatMap(function ($category) {
                return $category->layers->flatMap(function ($layer) use ($category) {
                    return $layer->levels->map(function ($level) use ($category, $layer) {
                        return(object) [
                            'id' => $level->id,
                            'name' => $level->name,
                            'layer' => $layer->name,
                            'category' => $category->name,
                        ];
                    });
                });
            });
        return view('school_admin.store-items.edit',compact('award','roles','levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAwardRequest $request, StoreItem $award)
    {
        $this->authorize('update', $award);
        $validated = $request->validated();
        if ($request->hasFile('image_url')) {
            if ($award->image_url && \Storage::disk('images')->exists($award->image_url)) {
                \Storage::disk('images')->delete($award->image_url);
            }
            $imagePath = $request->file('image_url')->store('awards', 'images');
            $validated['image_url'] = $imagePath;
        }

        $award->update($validated);

        return redirect()->route('awards.index')
            ->with('success', 'تم تحديث الجائزة بنجاح');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StoreItem $award)
    {
        $this->authorize('delete', $award);
        if ($award->image_url && \Storage::disk('images')->exists($award->image_url)) {
            \Storage::disk('images')->delete($award->image_url);
        }
        $award->delete();
        return redirect()->route('awards.index')
            ->with('success', 'تم حذف الجائزة بنجاح');
    }


}
