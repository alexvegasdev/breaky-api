<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
class ProductController extends Controller
{
    public function __construct(
     private readonly ProductService $saleService
    ) {}
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->saleService->createProduct(
            $request->validated()
        );

        return ProductResource::make($product)
            ->response()
            ->setStatusCode(201);
    }
    
    public function update(Product $product, UpdateProductRequest $request)
    {
        $updatedProduct = $this->saleService->updateProduct(
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
