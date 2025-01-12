<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Installation;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstallationRequest;
use App\Http\Resources\V1\InstallationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Installation controller
 */
class InstallationController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
//        return InstallationResource::collection(Installation::paginate(20));
        return InstallationResource::collection(Installation::all());
    }

    /**
     * @param InstallationRequest $request
     * @return InstallationResource
     */
    public function store(InstallationRequest $request): InstallationResource
    {
        $installation = Installation::create($request->validated());
        return new InstallationResource($installation);
    }

    /**
     * @param Installation $installation
     * @return InstallationResource
     */
    public function show(Installation $installation): InstallationResource
    {
        return new InstallationResource($installation);
    }

    /**
     * @param InstallationRequest $request
     * @param Installation $installation
     * @return InstallationResource
     */
    public function update(InstallationRequest $request, Installation $installation): InstallationResource
    {
        $installation->update($request->validated());
        return new InstallationResource($installation);
    }

    /**
     * @param Installation $installation
     * @return JsonResponse
     */
    public function destroy(Installation $installation): JsonResponse
    {
        $installation->delete();
        return response()->json(['message' => 'Installation deleted']);
    }
}
