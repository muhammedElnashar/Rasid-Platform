<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Enum\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLogsRequest;
use App\Models\BehaviorLog;
use App\Models\Role;
use App\Models\User;
use App\Services\LogServices;
use Illuminate\Http\Request;

class BehaviorLogController extends Controller
{
    protected $logsService;
    public function __construct(LogServices $logsService)
    {
        $this->logsService = $logsService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs=auth()->user()->school->logs()->with('user','issuedBy','cardItem.category.card')->get();
        return view('school_admin.logs.index',compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $school = auth()->user()->school;
        $roles = Role::ExpectModeratorAndAdmin()->get();
        $users = User::select('id', 'full_name', 'role_id','username')
            ->where('school_id', auth()->user()->school_id)
            ->get();
        $cards = $school->cards()->with('categories.items')->get();

        return view('school_admin.logs.create',compact('users','roles','cards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLogsRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();
        $this->logsService->storeLogs($data, $user);
        return redirect()->route('logs.index')->with('success', 'تم اصدار السجل بنجاح');
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
    public function edit(BehaviorLog $log)
    {
        if ($log->status !== StatusEnum::Pending) {
            return redirect()->route('logs.index')->with('error', 'لا يمكن تعديل السجل بعد اعتماده او رفضه');
        }
        $log->load('cardItem.category.card', 'user');
        $school= auth()->user()->school;
        $roles = Role::ExpectModeratorAndAdmin()->get();
        $users = User::select('id', 'full_name', 'role_id','username')
            ->where('school_id', auth()->user()->school_id)
            ->get();
        $cards = $school->cards()->with('categories.items')->get();


        return view('school_admin.logs.edit',compact('users','roles','log','cards'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLogsRequest $request, BehaviorLog $log)
    {
        if ($log->status !== StatusEnum::Pending) {
            return redirect()->route('logs.index')->with('error', 'لا يمكن تعديل السجل بعد اعتماده او رفضه');
        }
        $data = $request->validated();
        $user = auth()->user();
        $this->logsService->updateLogs($data, $user, $log);
        return redirect()->route('logs.index')->with('success', 'تم تعديل السجل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BehaviorLog $log)
    {
        if ($log->status !== StatusEnum::Pending) {
        return redirect()->route('logs.index')->with('error', 'لا يمكن تعديل السجل بعد اعتماده او رفضه');
    }
        $log->delete();
        return redirect()->route('logs.index')->with('success', 'تم حذف السجل بنجاح');
    }
    public function approve(BehaviorLog $log)
    {
        if ($log->status !== StatusEnum::Pending) {
            return redirect()->route('logs.index')->with('error', 'لا يمكن اعتماد السجل بعد اعتماده او رفضه');
        }
        $this->logsService->approve($log);
        return redirect()->route('logs.index')->with('success', 'تم اعتماد السجل بنجاح');
    }

    public function reject(BehaviorLog $log)
    {
        if ($log->status !== StatusEnum::Pending) {
            return redirect()->route('logs.index')->with('error', 'لا يمكن اعتماد السجل بعد اعتماده او رفضه');
        }
        $this->logsService->reject($log);
        return redirect()->route('logs.index')->with('success', 'تم رفض السجل ');

    }

    public function activation(BehaviorLog $log)
    {
        $this->logsService->activation($log);

        return back()->with('success', $log->active ? 'تم التفعيل' : 'تم التعطيل');
    }

}
