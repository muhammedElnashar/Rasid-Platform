<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\Stage;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Stage $stage,Grade $grade)
    {
        $this->authorize('viewAny', Classes::class);
        $school = auth()->user()->school;
        if (!$school) {
            return redirect()->route('home')->with('error', __('message.no_school_access'));
        }
        $classes = $grade->classes()->paginate(5);
        return view('school_admin.classes.index', compact('grade','stage','classes'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Stage $stage,Grade $grade)
    {
        $this->authorize('create', Classes::class);
        return view('school_admin.classes.create', compact('grade','stage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Stage $stage,Grade $grade)
    {
        $this->authorize('create',Classes::class);
       $data= $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $grade->classes()->create($data);
        return redirect()->route('stages.grades.classes.index', [$stage, $grade])->with('success', __('message.created', ['item' => __('message.class')]));
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
    public function update(Request $request, Stage $stage,Grade $grade,Classes $class)
    {
        $this->authorize('update', $class);
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $class->update($data);
        return redirect()->route('stages.grades.classes.index', [$stage, $grade])->with('success', __('message.updated', ['item' => __('message.class')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( Stage $stage,Grade $grade,Classes $class)
    {
        $this->authorize('delete', $class);
        $class->delete();
        return redirect()->route('stages.grades.classes.index', [$stage, $grade])->with('success', __('message.deleted', ['item' => __('message.class')]));
    }
}
