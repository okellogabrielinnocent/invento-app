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
    public function delete($id)
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
    public function paginate($number)
    {
        return $this->model::paginate($number);
    }
}
