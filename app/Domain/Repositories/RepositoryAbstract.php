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
}
