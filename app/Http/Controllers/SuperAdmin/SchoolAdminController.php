<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolAdminRequest;
use App\Http\Requests\UpdateSchoolAdminRequest;
use App\Models\School;
use App\Models\User;
use App\Notifications\CustomResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class SchoolAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = User::where('role_id', 2)->paginate(5);
        return view('super_admin.school_admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super_admin.school_admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolAdminRequest $request)
    {
        $data = $request->validated();

        $school = School::create([
            'name' => $data['school_name'],
        ]);
        $admin = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt(str()->random(16)),
            'role_id' => 2,
            'school_id' => $school->id,
        ]);
        $token = app('auth.password.broker')->createToken($admin);
        $admin->notify(new CustomResetPassword($token));
        return redirect()->route('admin.index')
            ->with('success', __('message.created', ['item' => __('message.admin')]));
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
    public function update(UpdateSchoolAdminRequest $request, User $admin)
    {
        $data = $request->validated();
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $admin->update($data);

        return redirect()
            ->route('admin.index')
            ->with('success', __('message.updated', ['item' => __('message.admin')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        $admin->delete();
        return redirect()
            ->route('admin.index')
            ->with('success', __('message.deleted', ['item' => __('message.admin')]));
    }

}
