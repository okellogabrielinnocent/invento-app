<?php

namespace App\Http\Controllers\ServiceSale;

use App\ServiceSale;
use Illuminate\Database\Eloquent\Model;

class ServiceSaleRepository
{
    public $model;

    public function __construct(ServiceSale $model)
    {
        $this->model = $model;
    }

    public function findAll()
    {
        $this->model::all();
    }

    public function findOneOrFail($id)
    {
        return $this->model::findOneOrFail($id);
    }

    public function findByKey($key, $value): ?Model
    {
        return $this->model::where($key, $value)->first();
    }

    public function findManyBykey($key, $value): ?Model
    {
        return $this->model::findManyBykey($key, $value);
    }
    public function delete($id): ?model
    {
        return $id->delete();
    }

    public function paginate($number)
    {
        return $this->model::paginate($number);
    }
}
