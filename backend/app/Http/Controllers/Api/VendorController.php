<?php

namespace App\Http\Controllers\Api;

use App\DTOs\VendorData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\StoreVendorRequest;
use App\Http\Requests\Vendor\UpdateVendorRequest;
use App\Http\Resources\VendorResource;
use App\Services\VendorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VendorController extends Controller
{
    public function __construct(
        private readonly VendorService $vendorService,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return VendorResource::collection($this->vendorService->all());
    }

    public function show(int $id): VendorResource|JsonResponse
    {
        $vendor = $this->vendorService->findById($id);

        if (!$vendor) {
            return response()->json(['message' => 'Vendor not found.'], 404);
        }

        return new VendorResource($vendor);
    }

    public function store(StoreVendorRequest $request): VendorResource
    {
        $vendor = $this->vendorService->create(
            VendorData::fromArray($request->validated()),
            $request->user()->id,
        );

        return new VendorResource($vendor);
    }

    public function update(UpdateVendorRequest $request, int $id): VendorResource|JsonResponse
    {
        $vendor = $this->vendorService->findById($id);

        if (!$vendor) {
            return response()->json(['message' => 'Vendor not found.'], 404);
        }

        $updated = $this->vendorService->update(
            $vendor,
            VendorData::fromArray($request->validated()),
        );

        return new VendorResource($updated);
    }

    public function destroy(int $id): JsonResponse
    {
        $vendor = $this->vendorService->findById($id);

        if (!$vendor) {
            return response()->json(['message' => 'Vendor not found.'], 404);
        }

        $this->vendorService->delete($vendor);

        return response()->json(['message' => 'Vendor deleted.']);
    }
}