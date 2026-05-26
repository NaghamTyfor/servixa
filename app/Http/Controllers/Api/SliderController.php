<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SliderResource;
use App\Services\SliderService;
use Illuminate\Http\JsonResponse;

class SliderController extends Controller
{
    public function __construct(protected SliderService $sliderService)
    {
    }

    public function index(): JsonResponse
    {
        $sliders = $this->sliderService->activeForApi();

        return response()->json([
            'status' => true,
            'data'   => SliderResource::collection($sliders),
        ]);
    }
}
