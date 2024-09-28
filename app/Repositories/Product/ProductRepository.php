<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\AbstractRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository extends AbstractRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function index(int $perPage, array $data): LengthAwarePaginator
    {

        return $this->model
        ->when(!empty($data["category"]), function ($query) use ($data) {
            return $query->where('category_id', $data["category"]);
        }) 
        ->when(!empty($data["name"]), function ($query) use ($data) {
            return $query->where('name', 'LIKE', '%' . $data["name"] . '%');
        })  
        ->when(!empty($data["without_image"]), function ($query) {
            return $query->whereNull('image_url');
        })
        ->when(!empty($data["with_image"]), function ($query) {
            return $query->whereNotNull('image_url');
        })
        ->paginate($perPage);
    }
}
