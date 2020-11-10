<?php

namespace App\Services;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseService
{
    /**
     * @var object
     */
    protected $repository;

    /**
     * BaseService constructor.
     * @param object $repository
     */
    protected function __construct(object $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return object
     */
    public function all(): object
    {
        return $this->repository->all();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param string $column
     * @param $value
     * @return object
     */
    public function findByColumn(string $column, $value): object
    {
        return $this->repository->findByColumn($column, $value);
    }

    /**
     * @param array $attributes
     * @return object
     */
    public function save(array $attributes): object
    {
        return $this->repository->save($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes): bool
    {
        return $this->repository->find($id)->update($attributes);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return $this->repository->destroy($id);
    }

    /**
     * @param array $attributes
     * @return object
     */
    public function create(array $attributes): object
    {
        return $this->repository->create($attributes);
    }
}
