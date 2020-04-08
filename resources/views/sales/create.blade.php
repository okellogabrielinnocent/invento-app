@extends('layouts.dashboard')

@section('dashboard-content')

    <div class="container">
        <h3 class="mb-4"> Add Sale </h3>
        <form method="post" action="{{route('sales.store')}}">
            @csrf
            <div class="form-group row">
                <label for="customer" class="col-md-2 col-form-label text-md-right">{{ __('Customer') }}</label>
                <div class="col-md-6">
                    <select name="customer_id" class="custom-select mb-6  {{$errors->has('customer_id') ? 'is-invalid': ''}}">
                        <option disabled selected value="select">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('customer_id'))
                        <span id="code-error" class="error text-danger" for="input-branch_id">{{ $errors->first('customer_id') }}</span>
                    @endif
                </div>

            </div>


            <div class="form-group row">
                <label for="item" class="col-md-2 col-form-label text-md-right">{{ __('Item') }}</label>
                <div class="col-md-6">
                    <select name="item_id" class=" custom-select mb-2 {{$errors->has('item_id') ? 'is-invalid': ''}}">
                        <option selected disabled>Select Item</option>
                        @foreach($items as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('item_id'))
                        <span id="code-error" class="error text-danger" for="input-branch_id">{{ $errors->first('item_id') }}</span>
                    @endif
                </div>

            </div>

            <div class="form-group row">
                <label for="qauntity" class="col-md-2 col-form-label text-md-right">{{ __('Quntity') }}</label>
                <div class="col-md-6">
                    <input placeholder="Quantity" name="quantity" type="number"
                           class="form-control {{$errors->has('quantity') ? 'is-invalid': ''}} ">
                    <div class="invalid-feedback">
                        @if ($errors->has('quantity'))
                            <span id="code-error" class="error text-danger" for="input-branch_id">{{ $errors->first('quantity') }}</span>
                        @endif
                    </div>
                </div>

            </div>

            <button class="btn btn-primary" type="submit">Submit </button>

        </form>
        @if ($errors->has('saleable'))
            <span id="code-error" class="error text-danger" for="input-branch_id">{{ $errors->first('saleable') }}</span>
        @endif
    </div>
@endsection

