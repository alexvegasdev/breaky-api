<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function getAllSales(): Collection
    {
        return Sale::with('saleItems.product')
            ->orderByDesc('sale_date')
            ->get();
    }
    public function createSale(array $data): Sale
    {
        return DB::transaction(function () use ($data) {

            $products = $this->getProducts($data['products']);

            $totalAmount = $this->calculateTotal(
                $products,
                $data['products']
            );

            $payment = $this->calculateChange(
                $data['payment_method'],
                $data['amount_received'] ?? null,
                $totalAmount
            );

            $sale = $this->createSaleRecord(
                $data,
                $totalAmount,
                $payment['amount_received'],
                $payment['change']
            );

            $this->createSaleItems(
                $sale,
                $products,
                $data['products']
            );

            return $sale->load('saleItems.product');
        });
    }

    private function createSaleRecord(array $data, float $totalAmount,?float $amountReceived,?float $change): Sale 
    {
        return Sale::create([
            'payment_method' => $data['payment_method'],
            'sale_date' => now(),
            'total_amount' => $totalAmount,
            'amount_received' => $amountReceived,
            'change' => $change,
        ]);
    }

    private function getProducts(array $items): Collection
    {
        $ids = collect($items)
            ->pluck('product_id');

        return Product::query()
            ->where('status', 'activo')
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');
    }

    private function calculateTotal(Collection $products, array $items): float
    {
        $total = 0;

        foreach ($items as $item) {

            $product = $products->get($item['product_id']);

            $total += $this->calculateSubtotal(
                $product->price,
                $item['quantity']
            );
        }

        return $total;
    }

    private function calculateChange(string $paymentMethod,?float $amountReceived, float $totalAmount): array {

        if ($paymentMethod === 'yape') {
            return [
                'amount_received' => null,
                'change' => null,
            ];
        }

        if ($amountReceived < $totalAmount) {
            throw new \Exception('Insufficient amount received.');
        }

        return [
            'amount_received' => $amountReceived,
            'change' => $amountReceived - $totalAmount,
        ];
    }

    private function createSaleItems(
        Sale $sale,
        Collection $products,
        array $items
    ): void {
        foreach ($items as $item) {
            $product = $products->get($item['product_id']);

            $sale->saleItems()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'subtotal' => $this->calculateSubtotal($product->price, $item['quantity']),
            ]);
        }
    }

    private function calculateSubtotal(float $price, int $quantity): float
    {
        return $price * $quantity;
    }
}