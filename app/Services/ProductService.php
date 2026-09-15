<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getProducts(?string $name = null, ?string $category = null)
    {
        return Product::where('status', 'activo')
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', "%{$name}%");
            })
            ->when($category, function ($query) use ($category) {
                $query->whereHas('category', function ($query) use ($category) {
                    $query->where('name', 'like', "%{$category}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }
}