<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class RepositoryAbstract
{
    /** @var Model */
    protected $model;

    public function all(array $filters = [])
    {
        if (empty($filters)) {
            return $this->model;
        }

        return $this->model->where($filters);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function findOrCreateOneBy($key, $value): Model
    {
        return $this->model->where($key, '=', $value)->first() ?? $this->model;
    }
}
