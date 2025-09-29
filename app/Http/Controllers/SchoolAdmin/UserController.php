<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Imports\UsersImport;
use App\Models\Role;
use App\Models\User;
use App\Notifications\CustomResetPassword;
use App\Services\PasswordResetService;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    protected UserServices $userServices;
    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $school = auth()->user()->school;
        $users = $school->users()->usersExpectAdmins()->get();
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
        $this->userServices->createUser($data, auth()->user()->school_id);
        return redirect()->route('users.index')->with('success', __('message.created', ['item' => __('message.user')]));
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
        return redirect()->route('users.index')->with('success', __('message.updated', ['item' => __('message.user')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('users.index')->with('success', __('message.deleted', ['item' => __('message.user')]));
    }

    public function activate(User $user)
    {
        $this->authorize('activate', $user);
        $this->userServices->activateUser($user);
        return redirect()
            ->route('users.index')
            ->with('success', 'تم التفعيل بنجاح');
    }

    public function deactivate(User $user)
    {
        $this->authorize('deactivate', $user);
        $this->userServices->suspendUser($user);
        return redirect()
            ->route('users.index')
            ->with('success', 'تم التعطيل بنجاح');
    }

    public function bulkUser()
    {
        $this->authorize('bulk', User::class);
        return view('school_admin.users.bulk-users');
    }

    public function import(Request $request)
    {
        $this->authorize('bulk', User::class);
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        try {
            $import = new UsersImport(auth()->user()->school_id);
            Excel::import($import, $request->file('file'));

            return redirect()->back()->with('success', count($import->newUsers) . ' مستخدم تم رفعهم بنجاح');

        } catch (ValidationException $e) {
            $messages = [];
            foreach ($e->failures() as $failure) {
                $row = $failure->row(); // الصف
                foreach ($failure->errors() as $error) {
                    $messages[] = "خطأ في الصف {$row}: {$error}";
                }
            }
            return redirect()->back()->withErrors($messages);
        }
    }


}
