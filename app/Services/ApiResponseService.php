<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class ApiResponseService
{
    /**
     * Generate a standardized API response for index or show methods.
     *
     * @param string $modelClass The model class (e.g., App\Models\Blog::class)
     * @param array|null $relations Array of relationships to eager load, or null
     * @param int|null $id The ID for show method, or null for index
     * @param string $resourceName The name of the resource for messages
     * @return JsonResponse
     */
    public static function apiResponse(string $modelClass, ?array $relations = null, ?int $id = null, string $resourceName = 'Resource'): JsonResponse
    {
        // Validate model class
        if (!class_exists($modelClass) || !is_subclass_of($modelClass, Model::class)) {
            return response()->json([
                'message' => 'Invalid model class'
            ], 500);
        }

        // Build query with relationships if provided
        $query = $relations ? $modelClass::with($relations) : $modelClass::query();

        if ($id !== null) {
            // Show method
            $item = $query->find($id);

            if (!$item) {
                return response()->json([
                    'message' => "{$resourceName} not found"
                ], 404);
            }

            return response()->json([
                'data' => $item,
                'message' => "{$resourceName} retrieved successfully"
            ], 200);
        }

        // Index method
        $items = $query->get();

        return response()->json([
            'data' => $items,
            'message' => "{$resourceName}s retrieved successfully"
        ], 200);
    }
}
?>