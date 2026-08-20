<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    /**
     * Get all public settings.
     */
    public function index(): JsonResponse
    {
        $settings = Setting::public();

        return response()->json([
            'success' => true,
            'data' => $settings,
        ]);
    }

    /**
     * Get public settings for a specific group.
     */
    public function group(string $group): JsonResponse
    {
        $settings = Setting::group($group);

        return response()->json([
            'success' => true,
            'data' => $settings,
        ]);
    }
}
