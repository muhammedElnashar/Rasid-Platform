<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentSubjectRequest;
use App\Http\Requests\UpdateStudentSubjectRequest;
use App\Models\StudentSubject;
use Illuminate\Http\Request;

class StudentSubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', StudentSubject::class);
        $studentSubjects = auth()->user()->school->studentSubjects()->with('student','subject')->get();
        $students = auth()->user()->school->users()->where('role_id', 3)->get();
        $subjects = auth()->user()->school->subjects;
        return view('school_admin.student-subjects.index',compact('studentSubjects','students','subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', StudentSubject::class);
        $students = auth()->user()->school->users()->where('role_id', 3)->get();
        $subjects = auth()->user()->school->subjects;
        return view('school_admin.student-subjects.create', compact('students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentSubjectRequest $request)
    {
        $this->authorize('create', StudentSubject::class);
        StudentSubject::create($request->validated());
        return redirect()->route('student-subjects.index')->with('success', __('message.created', ['item' => __('message.student_subject')]));

    }

    /**
     * Display the specified resource.
     */
    public function show(StudentSubject $studentSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentSubject $studentSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentSubjectRequest $request, StudentSubject $studentSubject)
    {
        $this->authorize('update', $studentSubject);
        $studentSubject->update($request->validated());
        return redirect()->route('student-subjects.index')->with('success', __('message.updated', ['item' => __('message.student_subject')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentSubject $studentSubject)
    {
        $this->authorize('delete', $studentSubject);
        $studentSubject->delete();
        return redirect()->route('student-subjects.index')->with('success', __('message.deleted', ['item' => __('message.student_subject')]));
    }
}
