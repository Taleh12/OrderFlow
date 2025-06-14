<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function index()
    {
        return response()->json($this->productService->list());
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create($request->validated());

        return response()->json($product, 201);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->update($product, $request->validated());

        return response()->json(['message' => 'Yeniləndi']);
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return response()->json(['message' => 'Silindi']);
    }
}
