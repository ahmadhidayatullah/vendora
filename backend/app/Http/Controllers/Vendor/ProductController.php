<?php

namespace App\Http\Controllers\Vendor;

use App\DTOs\ProductData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
    ) {}

    public function index(Request $request)
    {
        $vendor   = $request->user()->vendor;
        $products = $this->productService->allByVendor($vendor->id);

        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        return view('vendor.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $vendor = $request->user()->vendor;

        $this->productService->create(
            ProductData::fromArray(array_merge(
                $request->validated(),
                ['vendor_id' => $vendor->id]
            ))
        );

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(int $id, Request $request)
    {
        $product = $this->productService->findById($id);

        abort_if(!$product || $product->vendor_id !== $request->user()->vendor->id, 403);

        return view('vendor.products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $product = $this->productService->findById($id);

        abort_if(!$product || $product->vendor_id !== $request->user()->vendor->id, 403);

        $this->productService->update(
            $product,
            ProductData::fromArray(array_merge(
                $request->validated(),
                ['vendor_id' => $request->user()->vendor->id]
            ))
        );

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(int $id, Request $request)
    {
        $product = $this->productService->findById($id);

        abort_if(!$product || $product->vendor_id !== $request->user()->vendor->id, 403);

        $this->productService->delete($product);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted.');
    }
}