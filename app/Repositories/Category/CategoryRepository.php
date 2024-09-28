<?php

declare(strict_types=1);

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\AbstractRepository;

class CategoryRepository extends AbstractRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function toSelected(): array
    {
        return $this->model->get()->toArray();
    }
}
