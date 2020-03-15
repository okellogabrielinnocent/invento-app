<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Http\Controllers\User\UserRepository;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userRespository;

    // inject UserRepository 
    public function __construct(UserRepository $userRespository)
    {
        $this->userRepository = $userRespository;
    }
    /**
     * Display a listing of user resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $users = $this->userRepository->paginate(config('settings.pagination.small'));
        // TO-DO Add pagination to the database
        return view('users.index')->with(['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user resource in storage.
     *
     * @param CreateUserRequest $request
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);
        $data['role'] = $request->get('admin');
        User::create($data);
        return redirect()->to('users')->withSuccess('User Account Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Factory|View
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Factory|View
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->userRepository->update($user, $request);
        dd($user);
        return redirect()->back()->withSuccess('User has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return void
     * @throws Exception
     */
    public function destroy(User $user)
    {
        try {
            $this->userRepository->delete($user);
            return redirect()->to('users')->withSuccess('User Account Deleted');
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return back()->withErrors(["No user to delete!"]);
        }
    }
}
