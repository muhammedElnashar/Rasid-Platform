<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSchoolDataRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $school = auth()->user()->school;
        $this->authorize('update', $school);

        $data = $request->validated();
        if ($request->hasFile('logo')) {
            if ($school->logo && Storage::disk('images')->exists($school->logo)) {

                Storage::disk('images')->delete($school->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'images');
        }

        if ($request->hasFile('documents')) {
            if ($school->documents && Storage::disk('files')->exists($school->documents)) {
                Storage::disk('files')->delete($school->documents);
            }
            $data['documents'] = $request->file('documents')->store('documents', 'files');
        }

        $school->update($data);

        return redirect()->route('school.data.edit')
            ->with('success', __('message.updated', ['item' => __('message.school')]));
    }
}
