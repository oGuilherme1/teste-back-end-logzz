<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Product\ProductUploadImageRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\Product\ProductService;
use App\Services\UploadImage\UploadImageService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends AbstractController
{
    protected string $view = 'products.products-table';
    public function __construct(ProductService $service, protected UploadImageService $uploadImageService)
    {
        parent::__construct($service);
    }

    public function getStoreRequest(): string
    {
        return StoreProductRequest::class;
    }

    public function getUpdateRequest(): string
    {
        return UpdateProductRequest::class;
    }

}