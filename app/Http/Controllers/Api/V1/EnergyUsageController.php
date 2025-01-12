<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\EnergyUsage;
use App\Http\Requests\EnergyUsageRequest;
use App\Http\Resources\V1\EnergyUsageResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EnergyUsageController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
//        return EnergyUsageResource::collection(EnergyUsage::paginate(20));
        return EnergyUsageResource::collection(EnergyUsage::all());
    }

    /**
     * @param EnergyUsageRequest $request
     * @return EnergyUsageResource
     */
    public function store(EnergyUsageRequest $request): EnergyUsageResource
    {
        $energyUsage = EnergyUsage::create($request->validated());
        return new EnergyUsageResource($energyUsage);
    }

    /**
     * @param EnergyUsage $energyUsage
     * @return EnergyUsageResource
     */
    public function show(EnergyUsage $energyUsage): EnergyUsageResource
    {
        return new EnergyUsageResource($energyUsage);
    }

    /**
     * @param EnergyUsageRequest $request
     * @param EnergyUsage $energyUsage
     * @return EnergyUsageResource
     */
    public function update(EnergyUsageRequest $request, EnergyUsage $energyUsage): EnergyUsageResource
    {
        $energyUsage->update($request->validated());
        return new EnergyUsageResource($energyUsage);
    }

    /**
     * @param EnergyUsage $energyUsage
     * @return JsonResponse
     */
    public function destroy(EnergyUsage $energyUsage): JsonResponse
    {
        $energyUsage->delete();
        return response()->json(['message' => 'Energy usage deleted']);
    }
}
