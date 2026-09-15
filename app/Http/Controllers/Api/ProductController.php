<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
     private readonly ProductService $productService
    ) {}

    public function index(SearchProductRequest $request)
    {
        $name = $request->input('name');
        $category = $request->input('category');

        $products = $this->productService->getProducts($name, $category);

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct(
            $request->validated()
        );

        return ProductResource::make($product)
            ->response()
            ->setStatusCode(201);
    }
    
    public function update(Product $product, UpdateProductRequest $request)
    {
        $updatedProduct = $this->productService->updateProduct(
            $product,
            $request->validated()
        );

        return ProductResource::make($updatedProduct)
            ->response()
            ->setStatusCode(200);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json("El producto fue eliminado", 200);
    }
}
