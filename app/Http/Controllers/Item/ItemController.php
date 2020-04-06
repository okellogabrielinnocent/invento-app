<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Item\ItemRepository;
use App\Item;
use App\Http\Requests\CreateItemRequest;
use Exception;
use Illuminate\Contracts\View\Factory;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    protected $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TO-DO
        // Ask fro help from Jeseph of how to use the config values on pagination
        // get the pagination number or a default
        $items = $this->itemRepository->paginate(config('settings.pagination.small'));
        return view('items.index')->with(['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateItemRequest $request)
    {
        $request['name'] = strtoupper($request['size'] . "' " . $request['code'] . ' ' . $request['brand']);
        Item::create($request->all());
        return redirect()->route('items.index')->withSuccess('Item Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //return view with Item list
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('items.edit')->with(['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateItemRequest  $request
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function update(CreateItemRequest $request, Item $item)
    {
        $item->update($request->all());
        // check if quantity is greater than minimum available quantity
        if ($item->quantity > $item->min_quantity) {
            $item->update(['sealable' => true]);
        } else {
            $item->update(['sealable' => false]);
        }
        return redirect()->route('items.index')->withSuccess('Item Updated Succesfuly');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        try {
            $this->itemRepository->delete($item);
            return redirect()->to('items')->withSuccess('Item Deleted Succesfuly');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->withErrors(["No item to delete!"]);
        }
    }
    public function getTotalPrice()
    {
        $totalPrice = 0;

        foreach ($this->itemRepositories as $itemRepository) {
            $totalPrice = bcadd($totalPrice, $itemRepository->cost, 2);
        }

        return $totalPrice;
    }
}
