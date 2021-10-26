<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model::with($relations)->get($columns);
    }

    public function getData($params): \Illuminate\Database\Eloquent\Builder
    {
        $sort_by        = gv($params, 'sort_by', 'created_at');
        $order          = gv($params, 'order', 'desc');
        $relations      = gv($params, 'with', []);
        $columns        = gv($params, 'columns', ['*']);

        return $this->model::with($relations)->select($columns)->orderBy($sort_by, $order);
    }

    public function paginate($params): \Illuminate\Pagination\LengthAwarePaginator
    {
        $page_length = gv($params, 'page_length', 10);

        return $this->getData($params)->paginate($page_length);
    }

    public function count(): int
    {
        return $this->model::count();
    }

    public function getByCondition(array $condition, array $relations = [], array $columns = ['*']): Collection
    {
        return $this->model::where($condition)->with($relations)->get($columns);
    }

    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): Model
    {
        $model = $this->model::select($columns)->with($relations)->find($modelId);
        throw_if(!$model, ValidationException::withMessages(['message' => 'not found']));
        return $model->append($appends);
    }

    public function create(array $payload): ?Model
    {
        $model = $this->model::create($payload);
        return $model->fresh();
    }

    public function update(int $modelId, array $payload): Model
    {
        $model = $this->findById($modelId);
        $model->update($payload);
        return $model->refresh();
    }

    public function deleteById(int $modelId): bool
    {
        return $this->findById($modelId)->delete();
    }
}
