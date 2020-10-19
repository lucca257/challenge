<?php

namespace App\Services;


class BaseService
{
    protected $repository;

    protected function __construct(object $repository)
    {
        $this->repository = $repository;
    }

    public function all(): object
    {
        return $this->repository->all();
    }

    public function find(int $id): object
    {
        return $this->repository->find($id);
    }

    public function findByColumn(string $column, $value): object
    {
        return $this->repository->where($column, $value)->get();
    }

    public function save(array $attributes): bool
    {
        return $this->repository->insert($attributes);
    }

    public function update(int $id, array $attributes): bool
    {
        return $this->repository->find($id)->update($attributes);
    }

    public function destroy(int $id): bool
    {
        return $this->repository->destroy($id);
    }

    public function create(array $attributes): object
    {
        return $this->repository->create($attributes);
    }
}
