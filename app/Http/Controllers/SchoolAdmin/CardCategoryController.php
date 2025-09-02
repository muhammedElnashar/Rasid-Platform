<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAndUpdateNameRequest;
use App\Models\Card;
use App\Models\CardCategory;
use Illuminate\Http\Request;

class CardCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Card $card)
    {
        $this->authorize('viewAny', CardCategory::class);
        $user = auth()->user();
        if ($user->school_id !== $card->school_id) {
            return redirect()->route('home')->with('error', __('message.no_school_access'));
        }
        $categories = $card->categories()->paginate(5);
        return view('school_admin.card-categories.index', compact('categories','card'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Card $card)
    {
        $this->authorize('create', CardCategory::class);
        $user = auth()->user();
        if ($user->school_id !== $card->school_id) {
            return redirect()->route('home')->with('error', __('message.no_school_access'));
        }
        return view('school_admin.card-categories.create',compact('card'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAndUpdateNameRequest $request, Card $card)
    {
        $this->authorize('create', CardCategory::class);
        $data = $request->validated();
        $card->categories()->create($data);
        return redirect()->route('cards.categories.index', $card)->with('success', __('message.created', ['item' => __('message.category')]));
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
    public function update(StoreAndUpdateNameRequest $request,Card $card, CardCategory $category)
    {
        $this->authorize('update', $category);
        $data = $request->validated();
        $category->update($data);
        return redirect()->route('cards.categories.index', $card)->with('success', __('message.updated', ['item' => __('message.category')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card, CardCategory $category)
    {
        $this->authorize('delete', $category);
        $category->delete();
        return redirect()->route('cards.categories.index', $card)->with('success', __('message.deleted', ['item' => __('message.category')]));
    }
}
