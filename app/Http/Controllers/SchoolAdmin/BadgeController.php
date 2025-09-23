<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBadgeRequest;
use App\Http\Requests\UpdateBadgeRequest;
use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $school= auth()->user()->school;
        $badges = $school->badges;
        return view('school_admin.badges.index', compact('badges'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('school_admin.badges.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBadgeRequest $request)
    {
        $school= auth()->user()->school;
        // Validate the request data
        $validated = $request->validated();
        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('badges', 'images');
            $validated['image'] = $imagePath;
        }
        $school->badges()->create($validated);
        return redirect()->route('badges.index')->with('success', 'تم الإضافة بنجاح.');
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
    public function update(UpdateBadgeRequest $request, Badge $badge)
    {

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            \Storage::disk('images')->delete($badge->image);
            $imagePath = $request->file('image')->store('badges', 'images');
            $validated['image'] = $imagePath;
        }
        $badge->update($validated);
        return redirect()->route('badges.index')->with('success', 'تم التعديل بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Badge $badge)
    {
        \Storage::disk('images')->delete($badge->image);
        $badge->delete();
        return redirect()->route('badges.index')->with('success', 'تم الحذف بنجاح.');
    }
}
