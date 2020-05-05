@extends('layouts.dashboard')

@section('dashboard-content')

<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-sm-4 col-lg-3">
                <div class="card text-white bg-primary">
                <div class="card-body pb-0">
                    <h5>Monthly Sales Revenue</h5>
                    <p>${{ $total_sales_revenue }}</p>
                </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-info">
                <div class="card-body pb-0">
                    <h5>Monthly Sales</h5>
                    <p>{{$sales_count}}</p>
                </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-secondary">
                <div class="card-body pb-0">
                    <h5>Count of Items</h5>
                    <p>{{$items->sum('quantity') }}</p>
                </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-danger">
                <div class="card-body pb-0">
                    <h5>Out of Stock Items</h5>
                    <p>{{$out_of_stock}}</p>
                </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
        <div class="row col-md-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Size</th>
                    <th scope="col">Saleable</th>
                    <th scope="col">Brand</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Min Quantity</th>
                    <th>Low</th>
                    <th scope="col">Created</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->code}}</td>
                        <td>{{$item->size}}</td>
                        <td>{{$item->saleable ? 'Yes' : 'No'}}</td>

                        <td>{{$item->brand}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->minimum_quantity}}</td>
                        <td class="{{$item->quantity < $item->minimum_quantity ? 'text-danger': 'text-info' }}">{{$item->quantity < $item->minimum_quantity ? 'Yes': 'No' }}</td>
                        <td>{{$item->created_at->format('d/m/Y')}}</td>
                        <td>
                            <div class="row">
                                <div class="col-4">
                                   @if(auth()->user()->is_admin())
                                        <form class="col-md-8" action="{{ route('items.destroy', $item) }}" method="post">
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
                                        <a href="{{route('items.edit', $item)}}" class="btn btn-outline-primary btn-sm">Edit</a>
                                   @endif
                                </div>
                                <div class="col-4">
                                    <a href="{{route('items.show', $item)}}" class="btn btn-success btn-sm">View</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$items ?? ''->links()}}
	    </div>
    </div>
</div>

@endsection