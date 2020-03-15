@extends('layouts.dashboard')

@section('dashboard-content')
    <div class="container">
        <h1>Sales</h1>
        <a href="{{route('sales.create')}}" class="btn btn-sm btn-primary mb-5">Add Sale</a>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">customer</th>
                <th scope="col">product code</th>
                <th scope="col">quantity purchased</th>
                <th scope="col">Recorded by</th>
                <th scope="col">Created on</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{$sale->id}}</td>
                    <td>{{$sale->customer->name}}</td>
                    <td><a href="{{route('items.show',$sale->item->id)}}">{{$sale->item->code}}</a></td>
                    <td>{{$sale->quantity}}</td>
                    <td>{{$sale->sold_by->email}}</td>
                    <td>{{$sale->created_at->format('d/m/Y')}}</td>
                    <td>
                        <div class="row">
                            <div class="col-4">
                                @if(auth()->user()->is_admin())
                                    <form class="col-md-8" action="{{ route('sales.destroy', $sale) }}" method="post">
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
                                @if(auth()->user()->is_admin() || auth()->user()->is_admin())
                                    <a href="{{route('sales.edit', $sale)}}" class="btn btn-outline-primary btn-sm">Edit</a>
                                @endif
                            </div>
                            <div class="col-4">
                                <a href="{{route('sales.show', $sale)}}" class="btn btn-success btn-sm">View</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
