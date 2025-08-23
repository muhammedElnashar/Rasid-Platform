<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Notifications\CustomResetPassword;
use App\Services\PasswordResetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $passwordResetService;
    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $school = auth()->user()->school;
        if (!$school) {
            return redirect()->route('home')->with('error', __('message.no_school_access'));
        }
        $users = $school->users()->paginate(10);
        $roles= Role::whereNotIn('name', ['super_admin', 'school_admin'])->get();
        return view('school_admin.users.index', compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $roles= Role::whereNotIn('name', ['super_admin', 'school_admin'])->get();
        return view('school_admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        $data = $request->validated();
        $data['school_id'] = auth()->user()->school->id;
        $data['password'] = bcrypt(str()->random(16));
        $data['role_id'] = $request->role_id;
        $user=User::create($data);
        $this->passwordResetService->sendResetLink($user);
        return redirect()->route('users.index')->with('success', __('message.created', ['item' => __('message.employee')]));
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
    public function update(UpdateUserRequest $request,User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validated();
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        return redirect()->route('users.index')->with('success', __('message.updated', ['item' => __('message.employee')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('users.index')->with('success', __('message.deleted', ['item' => __('message.employee')]));
    }
}
