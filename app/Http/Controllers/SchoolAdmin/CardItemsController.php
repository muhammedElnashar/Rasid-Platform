<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAndUpdateNameRequest;
use App\Http\Requests\StoreItemRequest;
use App\Models\Card;
use App\Models\CardCategory;
use App\Models\CardItem;
use Illuminate\Http\Request;

class CardItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Card $card, CardCategory $category)
    {
        $this->authorize('viewAny', CardItem::class);
        $user = auth()->user();
        if (($user->school_id !== $card->school_id || $user->school_id !== $category->card->school_id)) {
            return redirect()->route('home')->with('error', __('message.no_school_access'));
        }
        $items = $category->items()->paginate(5);
        return view('school_admin.card-items.index', compact('items', 'card', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Card $card, CardCategory $category)
    {
        $this->authorize('create', CardItem::class);
        $user = auth()->user();
        if (($user->school_id !== $card->school_id || $user->school_id !== $category->card->school_id)) {
            return redirect()->route('home')->with('error', __('message.no_school_access'));
        }
        return view('school_admin.card-items.create', compact('card', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request, Card $card, CardCategory $category)
    {
        $this->authorize('create', CardItem::class);
        $user = auth()->user();
        if (($user->school_id !== $card->school_id || $user->school_id !== $category->card->school_id)) {
            return redirect()->route('home')->with('error', __('message.no_school_access'));
        }
        $data = $request->validated();
        $category->items()->create($data);
        return redirect()->route('cards.categories.items.index', [$card, $category])->with('success', __('message.created', ['item' => __('message.item')]));
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
    public function update(StoreItemRequest $request, Card $card, CardCategory $category, CardItem $item)
    {
        $this->authorize('update', $item);
        $data = $request->validated();
        $item->update($data);
        return redirect()->route('cards.categories.items.index', [$card, $category])->with('success', __('message.updated', ['item' => __('message.item')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card, CardCategory $category, CardItem $item)
    {
        $this->authorize('delete', $item);
        $item->delete();
        return redirect()->route('cards.categories.items.index', [$card, $category])->with('success', __('message.deleted', ['item' => __('message.item')]));
    }

}
