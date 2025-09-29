<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignInsigniaRequest;
use App\Http\Requests\InsigniaRequest;
use App\Http\Requests\UpdateInsigniaRequest;
use App\Models\Insignia;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInsignia;
use App\Services\InsigniaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InsigniaController extends Controller
{
    protected $insigniaService;

    public function __construct(InsigniaService $insigniaService)
    {
        $this->insigniaService = $insigniaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view-any', Insignia::class);
        $school = auth()->user()->school;
        $insignias =$school->insignias;
        return view('school_admin.insignias.index', compact('insignias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Insignia::class);

        return view('school_admin.insignias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InsigniaRequest $request)
    {
        $this->authorize('create', Insignia::class);

        $validated = $request->validated();
        $school = auth()->user()->school;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('insignias', 'images');
            $validated['image'] = $imagePath;
        }
        $validated['school_id'] = $school->id;
            Insignia::create($validated);
            return redirect()->route('insignias.index')->with('success', 'تم انشاء الشاره بنجاح');
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
    public function update(UpdateInsigniaRequest $request, Insignia $insignia)
    {
        $this->authorize('update', $insignia);
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($insignia->image && Storage::disk('images')->exists($insignia->image)) {
                Storage::disk('images')->delete($insignia->image);
            }
            $imagePath = $request->file('image')->store('insignias', 'images');
            $validated['image'] = $imagePath;
        }

        $insignia->update($validated);
        return redirect()->route('insignias.index')->with('success', 'تم تعديل الشاره بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insignia $insignia)
    {
        $this->authorize('delete', $insignia);

        if ($insignia->image && Storage::disk('images')->exists($insignia->image)) {
            Storage::disk('images')->delete($insignia->image);
        }

        $insignia->delete();

        return redirect()->route('insignias.index')
            ->with('success', 'تم حذف الشارة بنجاح');
    }


    public function assignPage()
    {
        $this->authorize('create', Insignia::class);
        $roles = Role::ExpectModeratorAndAdmin()->get();
        $school=Auth::user()->school;
        $insignias = $school->insignias;
        $users = User::select('id', 'full_name', 'role_id','username')
            ->where('school_id', auth()->user()->school_id)
            ->get();
     return view('school_admin.insignias.assign',compact('roles','insignias','users'));
    }
    public function assign(AssignInsigniaRequest $request)
    {
        $this->authorize('create', Insignia::class);
        $validated = $request->validated();
        $validated['issuer_id'] = auth()->id();
        $validated['award_date']  = now();
        $this->insigniaService->assignInsignia($validated);
        return redirect()
            ->route('insignias.index')
            ->with('success', 'تم اضافة الشاره للمستخدم بنجاح');
    }

    public function listPage()
    {
        $this->authorize('view-any', Insignia::class);

        $school = auth()->user()->school;
        $insignias = UserInsignia::with(['insignia', 'user', 'issuer'])
            ->whereHas('insignia', function ($query) use ($school) {
                $query->where('school_id', $school->id);
            })
            ->get();
        return view('school_admin.insignias.assign-list', compact('insignias'));
    }


}
