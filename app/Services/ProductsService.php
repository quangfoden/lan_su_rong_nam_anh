<?php

namespace App\Services;


use App\Models\Product;
use App\Repositories\ProductsRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductsService
{
    protected ProductsRepository $productsRepo;

    public function __construct(ProductsRepository $productsRepo)
    {
        $this->productsRepo = $productsRepo;
    }

    public function uploadNewProductImages(int $id, array $imgRequests): void
    {
        $dataImages = [];
        foreach ($imgRequests as $field => $file) {
            $path = '/uploads/products/' . $id . '/' . $field . '/';
            if (!Storage::disk('local')->exists($path)) {
                Storage::disk('local')->makeDirectory($path);
            }
            Storage::disk('local')->putFileAs($path, $file, $file->getClientOriginalName());
            $dataImages[$field] = $path . $file->getClientOriginalName();
        }

        $this->productsRepo->update($id, $dataImages);
    }

    public function getNewOverwriteProductImages(Product $product, array $imgRequests): array
    {
        foreach ($imgRequests as $field => $value) {
            if (!is_null($value)) {
                $path = public_path('uploads/products/' . $product->id . '/' . $field . '/');
                if (File::exists($path)) {
                    $files = File::allFiles(public_path('uploads/products/' . $product->id . '/' . $field . '/'));
                    foreach ($files as $file) {
                        if (file_exists($file->getPath())) unlink($file);
                    }
                }
            }
        }

        $dataImages = [];
        foreach ($imgRequests as $field => $file) {
            if (!is_null($file)) {
                $path = '/uploads/products/' . $product->id . '/' . $field . '/';
                if (!Storage::disk('local')->exists($path)) {
                    Storage::disk('local')->makeDirectory($path);
                }
                Storage::disk('local')->putFileAs($path, $file, $file->getClientOriginalName());
                $dataImages[$field] = $path . $file->getClientOriginalName();
            }
        }
        return $dataImages;
    }
}
