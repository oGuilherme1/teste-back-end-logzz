<?php

namespace App\Services;

use App\Repositories\AbstractRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class AbstractService
{
    public function __construct(protected AbstractRepository $repository) 
    {
        
    }

    public function index(int $perPage, array $data): LengthAwarePaginator
    {
        return $this->repository->index($perPage, $data);
    }

    public function show(int $id): array
    {
        return $this->repository->show($id);
    }

    public function store(array $data): array
    {
        return $this->repository->store($data);
    }

    public function update(int $id, array $data): void
    {
        $this->repository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function findBy(string $column, string|int $value): array|null
    {
        return $this->repository->findBy($column, $value);
    }
}
