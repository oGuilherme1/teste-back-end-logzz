<?php

declare(strict_types=1);

namespace App\Services\Category;

use App\Repositories\Category\CategoryRepository;
use App\Services\AbstractService;

class CategoryService extends AbstractService
{
    public function __construct(CategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    public function toSelected(): array
    {
        return $this->repository->toSelected();
    }
}