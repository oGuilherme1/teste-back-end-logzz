<?php

namespace App\Jobs;

use App\Dto\Products\StoreProductsByCommandDto;
use App\Services\Product\ProductService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CreateProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $url)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ProductService $service): void
    {
        $result = Http::get($this->url);

        if ($result->successful()) {

            $data = $result->json();

            if (isset($data["id"])) {
                try {
                    $input = StoreProductsByCommandDto::create(
                        $data["title"],
                        $data["price"],
                        $data["description"],
                        $data["category"],
                        $data["image"]
                    );
                    $service->storeProductsByCommand($input);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return;
                }
            } else {
                foreach ($data as $item) {
                    try {
                        $input = StoreProductsByCommandDto::create(
                            $item["title"],
                            $item["price"],
                            $item["description"],
                            $item["category"],
                            $item["image"]
                        );

                        $service->storeProductsByCommand($input);
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                        continue;
                    }
                }
            }
        }
    }
}
