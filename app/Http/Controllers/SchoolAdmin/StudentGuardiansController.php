<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentGuardianRequest;
use App\Http\Requests\UpdateStudentGuardianRequest;
use App\Models\StudentGuardian;
use App\Models\User;
use Illuminate\Http\Request;

class StudentGuardiansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', StudentGuardian::class);
        $school=auth()->user()->school;
        $studentGuardians= $school->studentGuardians()->with('student','guardian')->get();
        $students= $school->users()->onlyStudents()->get();
        $guardians= $school->users()->onlyGuardians()->get();
        return view('school_admin.student-guardian.index',compact('studentGuardians','students','guardians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', StudentGuardian::class);
        $school=auth()->user()->school;
        $students= $school->users()->onlyStudents()->get();
        $guardians= $school->users()->onlyGuardians()->get();
        return view('school_admin.student-guardian.create', compact('students', 'guardians'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentGuardianRequest $request)
    {
        $this->authorize('create', StudentGuardian::class);
        $data = $request->validated();
        StudentGuardian::create($data);
        return redirect()->route('student-guardian.index')
            ->with('success', __('message.created', ['item' => __('message.student_guardian')]));
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
    public function update(UpdateStudentGuardianRequest $request, StudentGuardian $studentGuardian)
    {
        $this->authorize('update', $studentGuardian);
        $data = $request->validated();
        $studentGuardian->update($data);
        return redirect()->route('student-guardian.index')
            ->with('success', __('message.updated', ['item' => __('message.student_guardian')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentGuardian $studentGuardian)
    {
        $this->authorize('delete', $studentGuardian);
        $studentGuardian->delete();
        return redirect()->route('student-guardian.index')
            ->with('success', __('message.deleted', ['item' => __('message.student_guardian')]));
    }

}
