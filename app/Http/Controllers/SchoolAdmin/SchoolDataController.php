<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSchoolDataRequest;
use Illuminate\Http\Request;

class SchoolDataController extends Controller
{
    public function edit()
    {
        $school = auth()->user()->school;
        if (!$school) {
            return redirect()->route('home')
                ->with('error', __('message.no_school_access'));
        }
        return view('school_admin.school.update', compact( 'school'));
    }
    public function update(UpdateSchoolDataRequest $request)
    {

        $data = $request->validated();
        $school = auth()->user()->school;
        $this->authorize('update', $school);
        $school->update($data);
        return redirect()->route('school.data.edit')
            ->with('success', __('message.updated', ['item' => __('message.school')]));

    }
}
