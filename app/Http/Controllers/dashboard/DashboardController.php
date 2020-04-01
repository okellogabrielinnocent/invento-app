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

class DashboardController extends Controller
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
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today_date = date('Y-m-d');

        $today = $this->saleRepository->model::whereDate('create_at', $today_date)->get()->count();
        $yesterday = $this->saleRepository->model::whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->get()->count();

        $month_date = date('m');
        $month = $this->saleRepository->model::whereMonth('created_at', $month_date)->get()->count();
        $previous_month = $this->saleRepository->model::whereMonth('created_at', date('m', strtotime('-1 month')))->get()->count();

        $year_date = date('Y');
        $year = $this->saleRepository->model::whereYear('created_at', $year_date)->get()->count();
        $previous_year = $this->saleRepository->model::whereYear('created_at', date('Y', strtotime('-1 year')))->get()->count();

        $sales = $this->saleRepository->findAll();

        $today_services = $this->serviceRepository->whereDate('created_at', $today_date)->count();
        $yesterday_services = $this->serviceRepository->whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->count();

        $month_services = $this->serviceRepository->whereMonth('created_at', $month_date)->count();
        $previous_month_services = $this->serviceRepository->whereMonth('created_at', date('m', strtotime('-1 month')))->count();

        $year_services = $this->serviceRepository->whereYear('created_at', $year_date)->count();
        $previous_year_services = $this->serviceRepository->whereYear('created_at', date('Y', strtotime('-1 year')))->count();

        $services = $this->serviceRepository->findAll();

        // for charts
        $current_sales = $this->saleRepository->model::select(
            DB::raw('sum(total) as sums'),
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

        return view('dashboard', compact('today', 'yesterday', 'month', 'previous_month', 'year', 'previous_year', 'sales', 'today_services', 'yesterday_services', 'month_services', 'previous_month_services', 'year_services', 'previous_year_services', 'services', 'current_sales', 'current_services'));
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
