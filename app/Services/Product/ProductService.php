<?php

declare(strict_types=1);

namespace App\Services\Product;

use App\Dto\Products\StoreProductsByCommandDto;
use App\Repositories\Product\ProductRepository;
use App\Services\AbstractService;
use App\Services\Category\CategoryService;
use App\Services\UploadImage\UploadImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ProductService extends AbstractService
{
    public function __construct(ProductRepository $repository, protected CategoryService $categoryService)
    {
        parent::__construct($repository);
    }

    public function storeProductsByCommand(StoreProductsByCommandDto $producInputDto): void
    {
        try {
            $existingNameProduct = $this->findBy('name', $producInputDto->getName());

            if ($existingNameProduct) {
                throw new \Exception('Ja existe produto com o nome: ' . $producInputDto->getName());
            }

            $existingNameCategory = $this->categoryService->findBy('name', $producInputDto->getCategory());

            if (!$existingNameCategory) {
                $dataCategory = [
                    'name' => strtolower($producInputDto->getCategory()),
                ];

                $aCategory = $this->categoryService->store($dataCategory);

                $categoryId = $aCategory["id"];
            } else {
                $categoryId = $existingNameCategory[0]["id"];
            }

            $dataProduct = [
                'name' => $producInputDto->getName(),
                'price' => $producInputDto->getPrice(),
                'description' => $producInputDto->getDescription(),
                'category_id' => $categoryId,
                'image_url' => $producInputDto->getImageUrl(),
            ];

            $this->repository->store($dataProduct);
        } catch (\Exception $e) {
            Log::error('Error ao criar o produto via command: ' . $e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function store(array $data): array
    {

        $data['image_url'] = !empty($data['image']) ? $this->uploadImage($data['image']) : null;
        $data['category_id'] = $data['category'];

        return $this->repository->store($data);
    }

    public function update(int $id, array $data): void
    {
        $uploadImageService = app(UploadImageService::class);

        $produtos = $this->repository->show($id);

        $imageUrl = $produtos['image_url'] ?? null;

        $imageExistsInStorage = !empty($imageUrl) && $uploadImageService->imageExists('products', $imageUrl);

        if (!empty($data['image'])) {
            if ($imageExistsInStorage) {
                $uploadImageService->deleteImage('products', $imageUrl);
            }
            $data['image_url'] = $this->uploadImage($data['image']);
        } else {
            $data['image_url'] = $imageUrl;
        }


        $data['category_id'] = (int) $data["category"];

        $this->repository->update($id, $data);
    }

    private function uploadImage(UploadedFile $image): string
    {
        $uploadImageService = app(UploadImageService::class);

        $imageUrl = $uploadImageService->storeImage('products', $image);

        return $imageUrl;
    }
}
