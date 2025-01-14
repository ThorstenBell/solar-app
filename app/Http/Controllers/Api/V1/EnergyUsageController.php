<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\EnergyUsage;
use App\Http\Requests\EnergyUsageRequest;
use App\Http\Resources\V1\EnergyUsageResource;
use Exception;
use Illuminate\Http\JsonResponse;

class EnergyUsageController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
//        return EnergyUsageResource::collection(EnergyUsage::paginate(20));
        try {
            return response()->json(['message' => 'success', 'data' => EnergyUsageResource::collection(EnergyUsage::all())]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @param EnergyUsageRequest $request
     * @return JsonResponse
     */
    public function store(EnergyUsageRequest $request): JsonResponse
    {
        try {
            $energyUsage = EnergyUsage::create($request->validated());
            return response()->json(['message' => 'success', 'data' => new EnergyUsageResource($energyUsage)], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @param EnergyUsage $energyUsage
     * @return JsonResponse
     */
    public function show(EnergyUsage $energyUsage): JsonResponse
    {
        try {
            return response()->json(['message' => 'success', 'data' => new EnergyUsageResource($energyUsage)]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @param EnergyUsageRequest $request
     * @param EnergyUsage $energyUsage
     * @return JsonResponse
     */
    public function update(EnergyUsageRequest $request, EnergyUsage $energyUsage): JsonResponse
    {
        try {
            $energyUsage->update($request->validated());
            return response()->json(['message' => 'success', 'data' => new EnergyUsageResource($energyUsage)]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @param EnergyUsage $energyUsage
     * @return JsonResponse
     */
    public function destroy(EnergyUsage $energyUsage): JsonResponse
    {
        try {
            $energyUsage->delete();
            return response()->json(['message' => 'Energy usage deleted']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
