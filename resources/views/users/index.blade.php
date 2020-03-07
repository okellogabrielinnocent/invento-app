@extends('layouts.app')

@section('content')
<div class="container">
        @if(auth()->user()->is_admin())
        <a href="{{route('users.create')}}" class="btn btn-primary btn-sm text-white row-12 mb-4">
            Create New User 
        </a>
        @endif

        <div class="row col-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                   <tr>
                       <td>{{$user->id}}</td>
                       <td>{{$user->name}}</td>
                       <td>{{$user->email}}</td>
                       <td>{{$user->created_at}}</td>
                       <td>
                           <div class="row">

                               <div class="col-3">
                                   @if(auth()->user()->is_admin() && auth()->id() !== $user->id)
                                   <form class="col-md-6" action="{{ route('users.destroy', $user) }}" method="post">
                                       @csrf
                                       @method('delete')
                                       <button
                                           data-original-title="" title=""
                                           onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''"
                                           type="button" rel="tooltip" class="btn btn-outline-danger btn-sm">
                                           Delete
                                       </button>
                                   </form>
                                   @endif
                               </div>

                               <div class="col-2">
                                   @if(auth()->user()->is_admin() || auth()->id() == $user->id)
                                   <a href="{{route('users.edit', $user)}}" class="btn btn-outline-primary btn-sm">Edit</a>
                                   @endif
                               </div>
                               <div class="col-2">
                                   <button class="btn btn-success btn-sm">View</button>
                               </div>
                           </div>
                       </td>
                   </tr>
                @endforeach
                </tbody>
            </table>
            {{$users->links()}}
        </div>

    </div>
@endsection