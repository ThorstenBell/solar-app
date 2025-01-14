<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Installation;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstallationRequest;
use App\Http\Resources\V1\InstallationResource;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Installation controller
 */
class InstallationController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
//        return InstallationResource::collection(Installation::paginate(20));
        try {
            return response()->json(['message' => 'success', 'data' => InstallationResource::collection(Installation::all())]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @param InstallationRequest $request
     * @return JsonResponse
     */
    public function store(InstallationRequest $request): JsonResponse
    {
        try {
            $installation = Installation::create($request->validated());
            return response()->json(['message' => 'success', 'data' => new InstallationResource($installation)], 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @param Installation $installation
     * @return JsonResponse
     */
    public function show(Installation $installation): JsonResponse
    {
        try {
            return response()->json(['message' => 'success', 'data' => new InstallationResource($installation)]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @param InstallationRequest $request
     * @param Installation $installation
     * @return JsonResponse
     */
    public function update(InstallationRequest $request, Installation $installation): JsonResponse
    {
        try {
            $installation->update($request->validated());
            return response()->json(['message' => 'success', 'data' => new InstallationResource($installation)]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * @param Installation $installation
     * @return JsonResponse
     */
    public function destroy(Installation $installation): JsonResponse
    {
        try {
            $installation->delete();
            return response()->json(['message' => 'Energy usage deleted']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
