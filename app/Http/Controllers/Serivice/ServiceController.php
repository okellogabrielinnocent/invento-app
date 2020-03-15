<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\ServiceRepository;
use App\Service;
use app\Http\Requests\CreateServiceRequest;

class ServiceController extends Controller
{
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TO-DO
        // get the pagination number or a default to 10
        $services = $this->$serviceRepository->paginate(config('settings.pagination.small')) ?? 10;
        return view('services.index')->with(['$services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateServiceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateServiceRequest $request)
    {
        Service::create($request->all());
        return redirect()->route('services.index')->withSuccess('Service created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $services
     * @return \Illuminate\Http\Response
     */
    public function show(Service $services)
    {
        //return view with Service list
        return view('services.show', compact('services'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('services.edit')->with(['Service' => $service]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateServiceRequest  $request
     * @param  int  $service
     * @return \Illuminate\Http\Response
     */
    public function update(CreateServiceRequest $request, Service $service)
    {
        $service->update($request->all());

        return redirect()->route('services')->withSuccess('Service Updated Succesfuly');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        try {
            $service->delete();
            return redirect()->to('services')->withSuccess('Service Deleted Succesfuly');
        } catch (\Exception $e) {
            // log errors the error in the system
            \Log::debug($e->getMessage());
            return "No Service to delete!";
        }
    }
}
