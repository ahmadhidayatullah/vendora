<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ProductData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\Services\VendorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly VendorService  $vendorService,
    ) {}

    public function index(int $vendorId): AnonymousResourceCollection|JsonResponse
    {
        $vendor = $this->vendorService->findById($vendorId);

        if (!$vendor) {
            return response()->json(['message' => 'Vendor not found.'], 404);
        }

        return ProductResource::collection(
            $this->productService->allByVendor($vendorId)
        );
    }

    public function store(StoreProductRequest $request, int $vendorId): ProductResource|JsonResponse
    {
        $vendor = $this->vendorService->findById($vendorId);

        if (!$vendor) {
            return response()->json(['message' => 'Vendor not found.'], 404);
        }

        $product = $this->productService->create(
            ProductData::fromArray(array_merge(
                $request->validated(),
                ['vendor_id' => $vendorId]
            ))
        );

        return new ProductResource($product);
    }

    public function show(int $vendorId, int $productId): ProductResource|JsonResponse
    {
        $product = $this->productService->findById($productId);

        if (!$product || $product->vendor_id !== $vendorId) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, int $vendorId, int $productId): ProductResource|JsonResponse
    {
        $product = $this->productService->findById($productId);

        if (!$product || $product->vendor_id !== $vendorId) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $updated = $this->productService->update(
            $product,
            ProductData::fromArray(array_merge(
                $request->validated(),
                ['vendor_id' => $vendorId]
            ))
        );

        return new ProductResource($updated);
    }

    public function destroy(int $vendorId, int $productId): JsonResponse
    {
        $product = $this->productService->findById($productId);

        if (!$product || $product->vendor_id !== $vendorId) {
            return response()->json(['message' => 'Product not found.'], 404);
        }

        $this->productService->delete($product);

        return response()->json(['message' => 'Product deleted.']);
    }
}