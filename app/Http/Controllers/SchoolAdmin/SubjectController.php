<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Subject::class);
        $school = auth()->user()->school;
        if (!$school){
            return redirect()->route('home')->with('error', __('message.no_school_access'));
        }
        $subjects = $school->subjects()->paginate(5);
        return view('school_admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Subject::class);
        return view('school_admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->authorize('create', Subject::class);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('subjects', 'name')]
        ]);
        $data['school_id'] = auth()->user()->school->id;
        Subject::create($data);

        return redirect()->route('subjects.index')->with('success', __('message.created', ['item' => __('message.subject')]));
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
    public function update(Request $request, Subject $subject)
    {
        $this->authorize('update', $subject);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('subjects', 'name')->ignore($subject->id)]
        ]);
        $subject->update($data);

        return redirect()->route('subjects.index')->with('success', __('message.updated', ['item' => __('message.subject')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $this->authorize('delete', $subject);
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', __('message.deleted', ['item' => __('message.subject')]));
    }
}
