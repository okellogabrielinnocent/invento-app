@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container">
        <h1>Service Sale</h1>
        <a href="{{route('service-sales.create')}}" class="btn btn-sm btn-primary mb-5">Add Sale</a>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Service Name</th>
                <th scope="col">Item </th>
                <th scope="col">Customer</th>
                <th>Cost</th>
                <th scope="col" class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{$sale->id}}</td>
                    <td>{{$sale->service->name}}</td>
                    <td>{{$sale->item->name}}</td>
                    <td>{{$sale->customer->email}}</td>
                    <td>{{$sale->service->labor + $sale->item->cost}}</td>

                    <td>
                        <div class="row">
                            <div class="col-4">
                                @if(auth()->user()->is_admin())
                                    <form class="col-md-8" action="{{ route('service-sales.destroy', $sale) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button
                                            data-original-title="" title=""
                                            onclick="confirm('{{ __("Are you sure you want to delete this item?") }}') ? this.parentElement.submit() : ''"
                                            type="button" rel="tooltip" class="btn btn-outline-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div class="col-4">
                                @if(auth()->user()->is_admin() || auth()->user()->is_data_clerk())
                                    <a href="{{route('service-sales.edit', $sale)}}" class="btn btn-outline-primary btn-sm">Edit</a>
                                @endif
                            </div>
                            <div class="col-4">
                                <a href="{{route('service-sales.show', $sale)}}" class="btn btn-success btn-sm">View</a>
                            </div>
                        </div>
                    </td>
                </tr>

            {{-- @empty
                <p>No information to be shown!</p> --}}
            @endforeach
            </tbody>
        </table>
    </div>
@endsection




{{-- @extends('layouts.dashboard')

@section('dashboard-content')

    <div class="container">
        <h1 class="mb-3"> Add Sale Services </h1>
        <form method="post" action="{{route('service-sales.store')}}">
            @csrf
            @method('post')
            <div class="select__user">
                <h2 class="col-md-2">
                    Customer
                </h2>
                <div class="col-md-6 row">
                    <select name="customer_id" class="custom-select mb-5  {{$errors->has('customer_id') ? 'is-invalid': ''}}">
                        <option disabled selected value="select">Select Customer</option>
                        @foreach($sales as $customer)
                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('customer_id'))
                        <span id="code-error" class="error text-danger" for="input-branch_id">{{ $errors->first('customer_id') }}</span>
                    @endif
                </div>

            </div>
            <div class="field_wrapper col-md-12 mb-3">
                <h3>Items</h3>
                <div>
                    <input class="row" placeholder="Enter Item Id" type="text" name="item_id[]" value=""/>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="optional[]" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            Optional
                        </label>
                    </div>
                    <a href="javascript:void(0);" class="add_button btn btn-sm btn-outline-primary row mt-3" title="Add field">Add Item</a>
                </div>

                @if ($errors->has('item_id'))
                    <span id="code-error" class="error text-danger" for="input-branch_id">{{ $errors->first('item_id') }}</span>
                @endif
            </div>
            <div class="select__item">
                <h2 class="col-md-2">
                    Services
                </h2>
                <div class="col-md-6 row">
                    <select name="service_id" class=" custom-select mb-2 {{$errors->has('service_id') ? 'is-invalid': ''}}">
                        <option selected disabled>Select Service</option>
                        @foreach($sales as $service)
                            <option value="{{$service->id}}">{{$service->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('service_id'))
                        <span id="code-error" class="error text-danger" for="input-branch_id">{{ $errors->first('service_id') }}</span>
                    @endif
                </div>

            </div>

            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
@endsection --}}