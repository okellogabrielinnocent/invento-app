<?php


namespace App\Http\Controllers\User;

// use Illuminate\Foundation\Auth\User;
use App\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository
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
    public function delete($id): ?model
    {
        return $id->delete();
    }
    public function findByKey($key, $value): ?Model
    {
        return $this->model::where($key, $value)->first();
    }

    public function findManyByKey($key, $value)
    {
        return $this->model::where($key, $value)->get();
    }

    public function update($id, $request)
    {
        $user = $this->findOneOrFail($id);
        $request = Input::only('username', 'email', 'password', 'password_confirmation', 'role');

        $user->fill($request);
        $checkMail = $this->findByKey('email', $request->get('email'));
        if ($checkMail && $request->get('email') !== $user->email) {
            return back()->withErrors(['email_taken' => "email $checkMail->email already in use"]);
        }
        $data = $request->only('email');

        if ($request->get('is_admin') && !$user->is_admin()) {
            $data['is_admin'] = true;
        } elseif (!$request->get('is_admin') && $user->is_admin()) {
            $data['is_admin'] = false;
        }

        return $user->save();
    }
    public function paginate($number)
    {
        return $this->model::paginate($number);
    }
}
