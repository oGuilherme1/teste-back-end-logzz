<?php

namespace App\Console\Commands;

use App\Jobs\CreateProductsJob;
use Illuminate\Console\Command;


class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {--id=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing products from an external API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ids = $this->option('id');

        if (empty($ids)) {
            $url = 'https://fakestoreapi.com/products';
            CreateProductsJob::dispatch($url);
        } else {
            foreach ($ids as $id) {
                $url = 'https://fakestoreapi.com/products/' . $id;
                CreateProductsJob::dispatch($url);
            }
        }
    }
}
