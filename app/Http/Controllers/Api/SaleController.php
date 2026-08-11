<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Resources\SaleResource;
use App\Services\SaleService;
use Illuminate\Http\JsonResponse;

class SaleController extends Controller
{
    public function __construct(
        private readonly SaleService $saleService
    ) {}

    public function index()
    {
        return SaleResource::collection(
            $this->saleService->getAllSales()
        );
    }
    
    public function store(StoreSaleRequest $request): JsonResponse
    {
        $sale = $this->saleService->createSale(
            $request->validated()
        );

        return SaleResource::make($sale)
            ->response()
            ->setStatusCode(201);
    }
}
