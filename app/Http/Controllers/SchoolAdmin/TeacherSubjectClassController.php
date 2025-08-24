<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeacherSubjectClassRequest;
use App\Http\Requests\UpdateTeacherSubjectClassRequest;
use App\Models\Classes;
use App\Models\TeacherSubjectClass;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherSubjectClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', TeacherSubjectClass::class);
        $school = auth()->user()->school;
        if (!$school){
            return redirect()->route('home')->with('error', __('message.no_school_access'));
        }
        $subjects = auth()->user()->school->subjects;
        $teachers = auth()->user()->school->users()->where('role_id', 4)->get();
        $classes = Classes::with('grade.stage.school')
            ->whereHas('grade.stage.school', function ($q) {
                $q->where('id', auth()->user()->school_id);
            })
            ->get();
        $teacherSubjectClass= TeacherSubjectClass::where('school_id', $school->id)
            ->with(['teacher', 'subject', 'class'])->get();
        return view('school_admin.teacher-subject-class.index', compact('teacherSubjectClass','subjects', 'teachers', 'classes'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', TeacherSubjectClass::class);
        $subjects = auth()->user()->school->subjects;
        $teachers = auth()->user()->school->users()->where('role_id', 4)->get();
        $classes = Classes::with('grade.stage.school')
            ->whereHas('grade.stage.school', function ($q) {
                $q->where('id', auth()->user()->school_id);
            })
            ->get();
        return view('school_admin.teacher-subject-class.create', compact('subjects', 'teachers', 'classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherSubjectClassRequest $request)
    {
        $this->authorize('create', TeacherSubjectClass::class);
        $data = $request->validated();
        $data['school_id'] = auth()->user()->school->id;
        TeacherSubjectClass::create($data);
        return redirect()->route('teacher-subject-classes.index')->with('success', __('message.created', ['item' => __('message.teacher-subject-class')]));
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
    public function update(UpdateTeacherSubjectClassRequest $request,TeacherSubjectClass $teacherSubjectClass)
    {
        $this->authorize('update', $teacherSubjectClass);
        $data = $request->validated();
        $teacherSubjectClass->update($data);
        return redirect()->route('teacher-subject-classes.index')->with('success', __('message.updated', ['item' => __('message.teacher-subject-class')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherSubjectClass $teacherSubjectClass)
    {
        $this->authorize('delete', $teacherSubjectClass);
        $teacherSubjectClass->delete();
        return redirect()->route('teacher-subject-classes.index')->with('success', __('message.deleted', ['item' => __('message.teacher-subject-class')]));
    }
}
