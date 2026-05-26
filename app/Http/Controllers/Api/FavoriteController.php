<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Models\Service;
use App\Services\FavoriteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct(protected FavoriteService $favoriteService)
    {
    }

public function index(Request $request): JsonResponse
{
    $favorites = $this->favoriteService->paginate($request->user(), 15);

    return FavoriteResource::collection($favorites)
        ->additional(['message' => __('favorites.list_retrieved')])
        ->response();
}

    public function toggle(Request $request, Service $service): JsonResponse
    {
        $result = $this->favoriteService->toggle($request->user(), $service);

        return response()->json([
            'status'  => true,
            'added'   => $result['added'],
            'message' => $result['added']
                ? __('favorites.added')
                : __('favorites.removed'),
        ]);
    }
}
