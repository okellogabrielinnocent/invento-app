<?php

namespace App\Http\Controllers;

use App\Dashboard;
use App\Http\Controllers\Dashboard\DashboardRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Service\ServiceRepository;
use App\Http\Controllers\Sale\SaleRepository;
use App\Http\Controllers\Item\ItemRepository;
use App\Http\Controllers\User\UserRepository;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $itemRepository;
    protected $userRepository;
    protected $saleRepository;
    public function __construct(

        UserRepository $userRepository,
        ItemRepository $itemRepository,
        // SaleRepository $saleRepository;
        ServiceRepository $serviceRepository
    ) {

        $this->userRepository = $userRepository;
        $this->itemRepository = $itemRepository;
        // $this->saleRepository = $saleRepository;
        $this->serviceRepository = $serviceRepository;
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today_date = date('Y-m-d');
        $month_date = date('m');
        $year_date = date('Y');
        $sales = $this->saleRepository->findAll();
        $services = $this->serviceRepository->findAll();
        $items = $this->itemRepository->findAll()->count();

        // a. On the dashboard:
        // - Total sales revenue (current month only),
        $total_sales_revenue = $this->saleRepository->whereMonth('created_at', $month_date)->count();
        // - A count of sales (current month only),
        $stock_items_count = $this->saleRepository->findAll()->whereMonth('created_at', $month_date)->count();
        // - Count of Items.
        $items = $this->itemRepository->findAll()->count();
        // - Count of Items Out of Stock.
        $stock_items_count = $this->itemRepository->findAll()->findManyByKey('quantity', 0)->count();

        // b. On the item details page:
        // - Total sales revenue (current month only), 
        // - A count of sales (current month only) from the specific item being viewed.
        // c. On the customer details page:
        // - Total sales revenue (current month only),
        // - A count of sales (current month only) to the specific customer being viewed.
        // d. On the staff details page:
        // - Total sales revenue (current month only), 
        // - A count of sales (current month only) by the specific staff being viewed.

        // for charts
        $current_sales = $this->saleRepository->model::select(
            DB::raw('sum(cost) as sums'),
            DB::raw("DATE_FORMAT(created_at,'%m') as months"),
            DB::raw("DATE_FORMAT(created_at,'%Y') as year")
        )
            ->whereYear('created_at',  date('Y'))
            ->groupBy('months')->get();

        $current_services = $this->serviceRepository->select(
            DB::raw('sum(amount) as sums'),
            DB::raw("DATE_FORMAT(created_at,'%m') as months"),
            DB::raw("DATE_FORMAT(created_at,'%Y') as year")
        )
            ->whereYear('created_at',  date('Y'))
            ->groupBy('months')->get();

        return view('dashboard', compact('items', 'sales,', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
