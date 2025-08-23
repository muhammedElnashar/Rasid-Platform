<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use Illuminate\Http\Request;

class StagesController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Stage::class);
        $school = auth()->user()->school;
        if (!$school){
            return redirect()->route('home')->with('error', __('message.no_school_access'));
        }
        $stages = $school->stages()->paginate(5);

        return view('school_admin.stages.index', compact('stages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Stage::class);
        return view('school_admin.stages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Stage::class);
        $data= $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $data['school_id'] = auth()->user()->school->id;

        Stage::create($data);

        return redirect()->route('stages.index')->with('success', __('message.created', ['item' => __('message.stage')]));
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stage $stage)
    {
        $this->authorize('update', $stage);

        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $stage->update($data);

        return redirect()->route('stages.index')->with('success', __('message.updated', ['item' => __('message.stage')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stage $stage)
    {
        $this->authorize('delete', $stage);
        $stage->delete();
        return redirect()->route('stages.index')->with('success', __('message.deleted', ['item' => __('message.stage')]));
    }
}
