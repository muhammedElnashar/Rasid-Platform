<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Stage;
use Illuminate\Http\Request;

class GradesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Stage $stage)
    {
        $this->authorize('viewAny', Grade::class);
        $school = auth()->user()->school;
        if (!$school) {
            return redirect()->route('home')->with('error', __('message.no_school_access'));
        }
        $grades = $stage->grades()->paginate(5);
        return view('school_admin.grades.index', compact('grades','stage'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Stage $stage)
    {
        $this->authorize('create', Grade::class);
        return view('school_admin.grades.create',compact('stage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Stage $stage)
    {
        $this->authorize('create', Grade::class);
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $stage->grades()->create($data);
        return redirect()->route('stages.grades.index', $stage)->with('success', __('message.created', ['item' => __('message.grade')]));
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
    public function update(Request $request,Stage $stage, Grade $grade)
    {
        $this->authorize('update', $grade);
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $grade->update($data);
        return redirect()->route('stages.grades.index', $stage)->with('success', __('message.updated', ['item' => __('message.grade')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stage $stage, Grade $grade)
    {
        $this->authorize('delete', $grade);
        $grade->delete();
        return redirect()->route('stages.grades.index', $stage)->with('success', __('message.deleted', ['item' => __('message.grade')]));
    }

}
