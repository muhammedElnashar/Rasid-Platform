<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupsRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Group::class);
        $school_id=Auth::user()->school_id;
        $groups = Group::with('leader')->where('school_id',$school_id)->get();
        return view('school_admin.groups.index',compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Group::class);
        $users = User::UsersExpectModerator()->get();
        return view('school_admin.groups.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupsRequest $request)
    {
        $this->authorize('create', Group::class);
        $data = $request->validated();
        do {
            $settlementCode = rand(10000000, 99999999);
        } while (Group::where('settlement_code', $settlementCode)->exists());

        $group = Group::create([
            'name' => $data['name'],
            'school_id' => auth()->user()->school_id,
            'leader_id' => $data['leader_id'],
            'settlement_code'=> $settlementCode,
        ]);
        $group->members()->sync($data['user_id']);
        return redirect()->route('groups.index')->with('success', 'تم إنشاء المجموعة بنجاح');

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
    public function edit(Group $group)
    {
        $this->authorize('update', $group);
        $users = User::UsersExpectModerator()->get();
        return view('school_admin.groups.edit',compact('group','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GroupsRequest $request, Group $group)
    {
        $this->authorize('update', $group);
        $data = $request->validated();
        $group->update([
            'name' => $data['name'],
            'leader_id' => $data['leader_id'],
        ]);
        $group->members()->sync($data['user_id']);
        return redirect()->route('groups.index')->with('success', 'تم تعديل المجموعة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete', $group);
        $group->members()->detach();
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'تم حذف المجموعة بنجاح');
    }
}
