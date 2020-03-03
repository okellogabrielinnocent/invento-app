<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;

class UserController extends Controller
{
    private $user;

    // inject UserRepository as 
    public function __construct(UserRepository $user)
    {
        $this->userRepository = $user;
        $this->middleware('isAdmin')->only('create', 'store', 'edit', 'update', 'index');
    }
    /**
     * Display a listing of user resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $users = $this->userRepository->paginate(10);
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
        $data['role'] = $request->get('isAdmin');
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
        return view('users.show')->with(['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Factory|View
     */
    public function edit(User $user)
    {
        return view('users.edit')->with(['user' => $user]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        User::whereId($id)->update($validatedData);

        return redirect('/users')->with('success', 'User has been successfully updated');
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
        $user->delete();
        return redirect()->to('users')->withSuccess('user account Deleted');
    }
}