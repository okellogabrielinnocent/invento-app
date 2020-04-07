<?php


namespace App\Http\Controllers\Item;

use App\Item;
use Illuminate\Database\Eloquent\Model;

class ItemRepository
{
    private $model;

    public function __construct(Item $model)
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
    public function delete($id)
    {
        return $id->delete();
    }

    public function paginate($number)
    {
        return $this->model::paginate($number);
    }
}
