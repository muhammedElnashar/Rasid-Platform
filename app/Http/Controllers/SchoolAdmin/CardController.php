<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAndUpdateNameRequest;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Card::class);
        $school = auth()->user()->school;
        $cards = $school->cards()->get();
        return view('school_admin.cards.index',compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Card::class);
        return view('school_admin.cards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAndUpdateNameRequest $request)
    {
        $this->authorize('create', Card::class);
        $data=$request->validated();
        $data['school_id'] = auth()->user()->school->id;
        Card::create($data);

        return redirect()->route('cards.index')->with('success',__('message.created', ['item' => __('message.card')]) );
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
    public function update(StoreAndUpdateNameRequest $request,Card $card)
    {
        $this->authorize('update', $card);
        $data=$request->validated();
        $card->update($data);
        return redirect()->route('cards.index')->with('success',__('message.updated', ['item' => __('message.card')]) );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        $this->authorize('delete', $card);
        $card->delete();
        return redirect()->route('cards.index')->with('success',__('message.deleted', ['item' => __('message.card')]) );
    }
}
