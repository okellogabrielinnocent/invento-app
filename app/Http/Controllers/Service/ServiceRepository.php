<?php


namespace App\Http\Controllers\Service;

use App\Service;
use Illuminate\Database\Eloquent\Model;

class ServiceRepository
{
    private $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function findAll()
    {
        return $this->model::all();
    }

    public function findOneOrFail($id): ?Model
    {
        return $this->model::findOrFail($id);
    }

    public function findByKey($key, $value): ?Model
    {
        return $this->model::where($key, $value)->first();
    }

    public function findManyByKey($key, $value)
    {
        return $this->model::where($key, $value)->get();
    }

    public function delete($id): ?model
    {
        return $id->delete();
    }

    public function paginate($number)
    {
        return $this->model::paginate($number);
    }
    public function whereDate($key, $value)
    {
        return $this->model::whereDate($key, $value)->get();
    }
    public function whereMonth($key, $value)
    {
        return $this->model::whereMonth($key, $value)->get();
    }
    public function whereYear($key, $value)
    {
        return $this->model::whereYear($key, $value)->get();
    }
    public function select($kay, $value)
    {
        return $this->model::select($kay, $value);
    }
}
