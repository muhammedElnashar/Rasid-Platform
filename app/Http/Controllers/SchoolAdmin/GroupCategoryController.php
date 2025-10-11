<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\GroupCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', GroupCategory::class);
        $school=Auth::user()->school;

        $categories= $school->groupCategories()->get();
        return view('school_admin.group-categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', GroupCategory::class);
        return view('school_admin.group-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', GroupCategory::class);
        $schoolId=Auth::user()->school_id;
        $data = $request->validate([
           'name'=>'required|string|max:255'
        ]);
        $data['school_id']=$schoolId;
        GroupCategory::create($data);
        return to_route('group-categories.index')->with('success','تم انشاء التصنيف بنجاح');
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
    public function update(Request $request, GroupCategory $groupCategory)
    {
        $this->authorize('update', $groupCategory);
        $data = $request->validate([
            'name'=>'required|string|max:255'
        ]);
        $groupCategory->update($data);
        return to_route('group-categories.index')->with('success','تم تعديل التصنيف بنجاح');    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GroupCategory $groupCategory)
    {
        $this->authorize('delete', $groupCategory);
        $groupCategory->delete();
        return to_route('group-categories.index')->with('success','تم حذف التصنيف بنجاح');
    }

}
