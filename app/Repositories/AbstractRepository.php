<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    public function __construct(protected Model $model)
    {  
    }

    public function index(int $perPage, array $data): LengthAwarePaginator
    {
        if ($perPage == 0) {
            return $this->model->all();
        }

        return  $this->model->paginate($perPage);
    }

    public function show(int $id): array
    {
        return $this->model->findOrFail($id)->toArray();
    }

    public function store(array $data): array
    {
        return $this->model->create($data)->toArray();
    }

    public function update(int $id, array $data): void
    {   
        $result = $this->model->findOrFail($id);
        $result->update($data);
    }

    public function delete(int $id): void
    {
        $result = $this->model->findOrFail($id);

        $result->delete();
    }

    public function findBy(string $column, string|int $value): array|null
    {
        $result = $this->model->where($column, $value)->get()->toArray();

        return (!$result) ? null : $result;
    }
    
}