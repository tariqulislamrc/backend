<?php

namespace App\Repositories\Eloquents;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface{

    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getData($params): \Illuminate\Database\Eloquent\Builder
    {
        $model = parent::getData($params);

        $name = gv($params, 'search');
        if ($name){
            $model = $model->where('name', 'like', "%{$name}%");
        }

        return $model;
    }

    public function paginate($params): \Illuminate\Pagination\LengthAwarePaginator
    {
        $page_length = gv($params, 'page_length', 10);

        return $this->getData($params)->paginate($page_length);
    }
}
