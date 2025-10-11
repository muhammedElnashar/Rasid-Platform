<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupsRequest;
use App\Models\Group;
use App\Models\GroupCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $users = User::UsersExpectModerator()
            ->select('id', 'full_name', 'role_id', 'username')
            ->where('school_id', auth()->user()->school_id)
            ->get();
        $categories = GroupCategory::where('school_id', auth()->user()->school_id)->get();
        return view('school_admin.groups.create',compact('users','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupsRequest $request)
    {
        $this->authorize('create', Group::class);
        $data = $request->validated();

        // 🔢 توليد كود التسوية الفريد
        do {
            $settlementCode = rand(10000000, 99999999);
        } while (Group::where('settlement_code', $settlementCode)->exists());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('groups', 'images');
            $data['image'] = $imagePath;
        }

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('groups', 'files');
            $data['file']=$filePath;
        }

        $group = Group::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'school_id' => auth()->user()->school_id,
            'leader_id' => $data['leader_id'],
            'settlement_code' => $settlementCode,
            'category_id'=>$data['category_id'],
            'image' => $imagePath,
            'file' => $filePath,
        ]);

        // 👥 ربط الأعضاء
        $group->members()->sync($data['user_id']);

        return redirect()
            ->route('groups.index')
            ->with('success', 'تم إنشاء المجموعة بنجاح ✅');
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
        $users = User::UsersExpectModerator()
            ->select('id', 'full_name', 'role_id', 'username')
            ->where('school_id', auth()->user()->school_id)
            ->get();
        $categories = GroupCategory::where('school_id', auth()->user()->school_id)->get();

        return view('school_admin.groups.edit',compact('group','users','categories'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(GroupsRequest $request, Group $group)
    {
        $this->authorize('update', $group);
        $data = $request->validated();

        // 🖼️ تحديث الصورة (وحذف القديمة)
        if ($request->hasFile('image')) {
            // حذف القديمة إذا وجدت
            if ($group->image && Storage::disk('images')->exists($group->image)) {
                Storage::disk('images')->delete($group->image);
            }

            // رفع الجديدة
            $data['image'] = $request->file('image')->store('groups', 'images');
        }

        // 📄 تحديث الملف (وحذف القديم)
        if ($request->hasFile('file')) {
            if ($group->file && Storage::disk('files')->exists($group->file)) {
                Storage::disk('files')->delete($group->file);
            }

            $data['file'] = $request->file('file')->store('groups', 'files');
        }

        // 🧱 تحديث البيانات العامة
        $group->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? $group->description,
            'leader_id' => $data['leader_id'],
            'image' => $data['image'] ?? $group->image,
            'file' => $data['file'] ?? $group->file,
        ]);

        // 👥 تحديث الأعضاء
        $group->members()->sync($data['user_id']);

        return redirect()->route('groups.index')->with('success', 'تم تعديل المجموعة بنجاح ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete', $group);

        try {
            // حذف الملفات إذا كانت موجودة فعلاً
            if (!empty($group->file) && Storage::disk('files')->exists($group->file)) {
                Storage::disk('files')->delete($group->file);
            }

            if (!empty($group->image) && Storage::disk('images')->exists($group->image)) {
                Storage::disk('images')->delete($group->image);
            }

            // فصل الأعضاء المرتبطين بالمجموعة
            $group->members()->detach();

            // حذف المجموعة
            $group->delete();

            return redirect()
                ->route('groups.index')
                ->with('success', 'تم حذف المجموعة بنجاح');
        } catch (\Exception $e) {
            // في حال حدوث خطأ أثناء الحذف
            return redirect()
                ->route('groups.index')
                ->with('error', 'حدث خطأ أثناء حذف المجموعة: ' . $e->getMessage());
        }
    }

    public function activationToggle(Group $group)
    {
        $this->authorize('activation', $group);

        $newActive = !$group->active;

        DB::transaction(function () use ($group, $newActive) {
            $group->update(['active' => $newActive]);

            if ($newActive) {
                DB::table('recharge_failed_attempts')
                    ->where('issued_to_id', $group->id)
                    ->delete();
            }
        });

        return back()->with('success', $newActive ? 'تم التفعيل' : 'تم التعطيل');
    }

}
