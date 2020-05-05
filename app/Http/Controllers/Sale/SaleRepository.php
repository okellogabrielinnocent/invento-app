<?php

namespace App\Http\Controllers\Sale;

use App\Sale;
use Illuminate\Database\Eloquent\Model;

class SaleRepository
{
    public $model;

    public function __construct(Sale $model)
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
    public function whereMonth($key, $value)
    {
        return $this->model::whereMonth($key, $value);
    }
}
