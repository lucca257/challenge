<?php

namespace App\Repositories;

/**
 * Class BaseRepository
 * @package App\Repositories
 */
class BaseRepository
{
    /**
     * @var object
     */
    protected $obj;

    /**
     * BaseRepository constructor.
     * @param object $obj
     */
    protected function __construct(object $obj)
    {
        $this->obj = $obj;
    }

    /**
     * @return object
     */
    public function all(): object
    {
        return $this->obj->all();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->obj->find($id);
    }

    /**
     * @param string $column
     * @param $value
     * @return object
     */
    public function findByColumn(string $column, $value): object
    {
        return $this->obj->where($column, $value)->get();
    }

    /**
     * @param array $attributes
     * @return object
     */
    public function save(array $attributes): object
    {
        return $this->obj->create($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes): bool
    {
        return $this->obj->find($id)->update($attributes);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return $this->obj->destroy($id);
    }

    /**
     * @param array $attributes
     * @return object
     */
    public function create(array $attributes): object
    {
        return $this->obj->create($attributes);
    }

    /**
     * @return object
     */
    public function last(): object
    {
        return $this->obj->last();
    }

    /**
     * @param $relations
     * @return object
     */
    public function findByRelations($relations): object
    {
        return $this->obj->with($relations)->get();
    }
}
