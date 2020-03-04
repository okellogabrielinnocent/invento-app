<?php


namespace App\Http\Controllers\User;


use App\Contracts\Repository;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements Repository
{
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findAll()
    {
        return $this->model::all();
    }

    public function findOneOrFail($id)
    {
        return $this->model::findOrFail($id);
    }

    public function findByKey($key, $value)
    {
        return $this->model::where($key, $value)->first();
    }

    public function findManyByKey($key, $value)
    {
        return $this->model::where($key, $value)->get();
    }

    public function update($id, $input)
    {
        $user = $this->find($id);
        $input = Input::only('username', 'email', 'password', 'password_confirmation','role');

        $user->fill($input);
        $checkMail = $this->findByKey('email', $request->get('email'));
        if($checkMail && $request->get('email') !== $user->email) {
            return back()->withErrors(['email_taken' => "email $checkMail->email already in use"]);
        }
        $data = $request->only('email');

        if($request->get('is_admin') && !$user->is_admin) {
            $data['is_admin'] = true;
        } elseif (!$request->get('is_admin') && $user->is_admin) {
            $data['is_admin'] = false;
        }

        return $user->save();
    }
}