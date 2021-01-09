<?php

namespace App\Domain\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class RepositoryAbstract
{
    /** @var Model */
    protected $model;

    public function all(array $filters): Collection
    {
        $attributes = !empty($filters) ? $filters : ['*'];

        return $this->model->get($attributes);
    }
}
