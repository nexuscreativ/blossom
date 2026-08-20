<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\ServiceRegistry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(
        protected ServiceRegistry $registry
    ) {}

    /**
     * List all services.
     */
    public function index(): JsonResponse
    {
        $services = Service::all();

        return response()->json([
            'success' => true,
            'data' => $services,
        ]);
    }

    /**
     * Get a single service.
     */
    public function show(Service $service): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $service,
        ]);
    }

    /**
     * Update service configuration.
     */
    public function update(Request $request, Service $service): JsonResponse
    {
        $validated = $request->validate([
            'config' => 'nullable|array',
            'credentials' => 'nullable|array',
            'sandbox_mode' => 'sometimes|in:sandbox,production',
            'is_enabled' => 'sometimes|boolean',
            'is_primary' => 'sometimes|boolean',
            'priority' => 'sometimes|integer',
        ]);

        if (isset($validated['credentials'])) {
            $service->credentials = $validated['credentials'];
            unset($validated['credentials']);
        }

        $service->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Service updated',
            'data' => $service,
        ]);
    }

    /**
     * Test a service connection.
     */
    public function test(Service $service): JsonResponse
    {
        $serviceInstance = $this->registry->get($service->category, $service->name);

        if (! $serviceInstance) {
            return response()->json([
                'success' => false,
                'message' => 'Service implementation not found',
            ], 404);
        }

        $result = $serviceInstance->test();
        $service->recordTest($result['success'], $result['message']);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => [
                'tested_at' => $service->last_tested_at,
                'last_result' => $service->last_test_result,
            ],
        ]);
    }

    /**
     * Enable a service.
     */
    public function enable(Service $service): JsonResponse
    {
        $service->update(['is_enabled' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Service enabled',
        ]);
    }

    /**
     * Disable a service.
     */
    public function disable(Service $service): JsonResponse
    {
        $service->update(['is_enabled' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Service disabled',
        ]);
    }
}
