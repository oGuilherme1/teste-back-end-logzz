<?php

declare(strict_types=1);

namespace App\Http\Controllers\Category;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\Category\CategoryService;
use Exception;
use Illuminate\Http\JsonResponse;

class CategoryController extends AbstractController
{
    protected string $view = 'category.category-table';
    public function __construct(CategoryService $service)
    {
        parent::__construct($service);
    }

    public function getStoreRequest(): string
    {
        return StoreCategoryRequest::class;
    }

    public function getUpdateRequest(): string
    {
        return UpdateCategoryRequest::class;
    }

    public function toSelected(): JsonResponse
    {
        try {
            $resource = $this->service->toSelected();

            return response()->json($resource);
        } catch(Exception $e) {
            return $this->handleException();
        }
    }
}