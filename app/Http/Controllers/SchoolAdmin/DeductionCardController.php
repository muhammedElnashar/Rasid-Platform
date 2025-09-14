<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Enum\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeductionCardRequest;
use App\Http\Requests\UpdateDeductionCardRequest;
use App\Models\DeductionCard;
use Illuminate\Http\Request;

class DeductionCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', DeductionCard::class);
        $cards=DeductionCard::where('school_id',auth()->user()->school_id)->orderBy('deduction_percent','asc')->get();
        return view('school_admin.deduction-cards.index',compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', DeductionCard::class);
        return view('school_admin.deduction-cards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeductionCardRequest $request)
    {
        $this->authorize('create', DeductionCard::class);
        $data= $request->validated();
        $data['school_id']=auth()->user()->school_id;
        DeductionCard::create($data);
        return to_route('deduction-cards.index')->with('success',__('message.created', ['item' => __('message.deduction_card')]));

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
    public function update(UpdateDeductionCardRequest $request,DeductionCard $deductionCard )
    {
        $this->authorize('update', $deductionCard);
        $data= $request->validated();
        $deductionCard->update($data);
        return to_route('deduction-cards.index')->with('success',__('message.updated', ['item' => __('message.deduction_card')]));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeductionCard $deductionCard)
    {
        $this->authorize('delete', $deductionCard);
        $deductionCard->delete();
        return to_route('deduction-cards.index')->with('success',__('message.deleted', ['item' => __('message.deduction_card')]));
    }
}
