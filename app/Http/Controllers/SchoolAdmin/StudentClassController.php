<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentClassRequest;
use App\Http\Requests\UpdateStudentClassRequest;
use App\Models\Classes;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class StudentClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', \App\Models\StudentClass::class);
        $students = auth()->user()->school->users()->where('role_id', 3)->get();
        $classes = Classes::with('grade.stage.school')
            ->whereHas('grade.stage.school', function ($q) {
                $q->where('id', auth()->user()->school_id);
            })
            ->get();
        $studentClasses= auth()->user()->school->studentClasses()->with('student','class.grade.stage')->get();
        return view('school_admin.student-class.index',compact('studentClasses','students','classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', \App\Models\StudentClass::class);
        $students = auth()->user()->school->users()->where('role_id', 3)->get();
        $classes = Classes::with('grade.stage.school')
            ->whereHas('grade.stage.school', function ($q) {
                $q->where('id', auth()->user()->school_id);
            })
            ->get();
        return view('school_admin.student-class.create', compact('students', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentClassRequest $request)
    {
        $this->authorize('create', \App\Models\StudentClass::class);
        \App\Models\StudentClass::create($request->validated());
        return to_route('student-classes.index')->with('success', __('message.created', ['item' => __('message.student_class')]));
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
    public function update(UpdateStudentClassRequest $request,StudentClass $studentClass)
    {
        $this->authorize('update', $studentClass);
        $studentClass->update($request->validated());
        return to_route('student-classes.index')->with('success', __('message.updated', ['item' => __('message.student_class')]));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentClass $studentClass)
    {
        $this->authorize('delete', $studentClass);
        $studentClass->delete();
        return to_route('student-classes.index')->with('success', __('message.deleted', ['item' => __('message.student_class')]));
    }
}
