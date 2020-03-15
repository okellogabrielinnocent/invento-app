<?php

namespace App\Http\Controllers\Sale;

use App\Events\ItemSold;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Sale\SaleRepository;
use App\Http\Controllers\Item\ItemRepository;
use App\Http\Controllers\User\UserRepository;
use App\Sale;
use App\Http\Requests\CreateSaleRequest;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    protected $itemRepository;
    protected $userRepository;
    protected $saleRepository;
    public function __construct(
        UserRepository $userRepository,
        ItemRepository $itemRepository,
        SaleRepository $saleRepository
    ) {

        $this->userRepository = $userRepository;
        $this->itemRepository = $itemRepository;
        $this->saleRepository = $saleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $sales = $this->saleRepository->model::with('customer', 'item', 'sold_by')
            ->get();
        // ->paginate(config('settings.pagination.small'));
        return view('sales.index')->with(['sales' => $sales]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $items = $this->itemRepository->findAll();
        $customer = $this->userRepository->findManyByKey('role', 'customer');
        return view('sales.create')->with(['items' => $items, 'customers' => $customer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateSaleRequest $request
     * @return RedirectResponse
     */
    public function store(CreateSaleRequest $request)
    {

        $sale = $request->only('customer_id', 'item_id', 'quantity');
        $item = $this->itemRepository->findOneOrFail($sale['item_id']);
        $data['staff_id'] = auth()->id();
        if (!$item->saleable) {
            return back()->withErrors(['saleable' => 'Item is not in stock']);
        }
        $sale = Sale::create($sale);
        ItemSold::dispatch($item, $sale->quantity);
        return redirect()->to('sales')->withSuccess('Sale Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Sale $sale
     * @return Factory|View
     */
    public function show(Sale $sale)
    {
        $items = $this->itemRepository->findAll();
        $customer = $this->userRepository->findManyByKey('role', 'customer');
        return view('sales.show')->with(['items' => $items, 'customers' => $customer, 'sale' => $sale]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Sale $sale
     * @return Factory|View
     */
    public function edit(Sale $sale)
    {
        $items = $this->itemRepository->findAll();
        $customer = $this->userRepository->findManyByKey('role', 'customer');
        return view('sales.edit')->with(['items' => $items, 'customers' => $customer, 'sale' => $sale]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateSaleRequest $request
     * @param Sale $sale
     * @return RedirectResponse
     */
    public function update(CreateSaleRequest $request, Sale $sale)
    {
        $item = $this->itemRepository->findOneOrFail($request->get('item_id'));

        $sale->update($request->only('customer_id', 'item_id', 'quantity'));
        //TODO learn more on events and creat an event to make sale
        ItemSold::dispatch($item, $request->get('quantity'));
        return redirect()->to('sales')->withSuccess('Sale updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $Sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        try {
            $sale->saleRepository->delete();
            return redirect()->to('sales')->withSuccess('Sale Deleted Succesfuly');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return redirect()->back()->withErrors(["No Sales to delete!"]);
        }
    }
}
