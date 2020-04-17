@extends('layouts.dashboard')

@section('dashboard-content')

    <div class="container">
        @if(auth()->user()->is_admin())
        <a href="{{route('users.show', $user)}}" class="btn btn-primary btn-sm text-white mb-5">
            Back To User
        </a>
        @endif
        <h3> Edit {{$user->name}} </h3>
        <form method="post" action="{{route('users.update', $user)}}">
            @csrf
            @method('put')
                <div class="form-group row">
                    <label for="validationServer01" class="col-md-2 col-form-label text-md-right">Name</label>
                    <div class="col-md-8">
                        <input name="name" type="text" class="form-control {{$errors->has('name') ? 'is-invalid': ''}} "
                            value="{{ $user->name }}">
                        <div class="invalid-feedback">
                            @if ($errors->has('name'))
                                <span id="branch_id-error" class="error text-danger" for="input-branch_id">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        @if ($errors->has('name_taken'))
                            <span id="branch_id-error" class="error text-danger" for="input-branch_id">{{ $errors->first('name_taken') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="validationServerUsername" class="col-md-2 col-form-label text-md-right">Email</label>
                    <div class="col-md-8">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend3">@</span>
                        </div>
                        <input name="email" type="text" class="form-control {{$errors->has('email') ? 'is-invalid': ''}}"
                               value="{{ $user->email }}" aria-describedby="inputGroupPrepend3">
                        <div class="invalid-feedback">
                            @if ($errors->has('email'))
                                <span id="branch_id-error" class="error text-danger" for="input-branch_id">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                    </div>
                    @if ($errors->has('email_taken'))
                        <span id="branch_id-error" class="error text-danger" for="input-branch_id">{{ $errors->first('email_taken') }}</span>
                    @endif
                    </div>
                </div>
            @if($user->is_admin())
                <div class="form-group row">
                <label for="role" class="col-md-2 col-form-label text-md-right">{{ __('Select User Type') }}</label>
                <div class="col-md-8">
                    <select class="form-control col-md-4 @error('role') is-invalid @enderror" name="role" id="role">
                    <option value='customer'>Customer</option>
                    <option value='data_clerk'>Data Clerk</option>
                    </select>
                    @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            @else
                <div class="form-group row">
                    <label for="role" class="col-md-2 col-form-label text-md-right">{{ __('Select User Type') }}</label>
                    <div class="col-md-6">
                        <select class="form-control col-md-4 @error('role') is-invalid @enderror" name="role" id="role">
                        <option value='customer'>Customer</option>
                        <option value='data_clerk'>Data Clerk</option>
                        <option value='admin'>Admin</option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            @endif
            <div class="form-group row col-md-6">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
@endsection

