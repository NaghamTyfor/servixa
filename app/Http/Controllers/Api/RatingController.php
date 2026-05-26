<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreRatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Services\RatingService;
use Illuminate\Http\JsonResponse;

class RatingController extends Controller
{
    public function __construct(
        private readonly RatingService $ratingService
    ) {}


    public function store(StoreRatingRequest $request, Service $service): JsonResponse
    {
        $serviceRequest = ServiceRequest::findOrFail($request->request_id);

        try {
            $rating = $this->ratingService->create(
                auth('api')->user(),
                $service,
                $serviceRequest,
                $request->validated()
            );

            return response()->json([
                'message' => __('rating.created'),
                'data'    => RatingResource::make($rating->load('user')),
            ], 201);
        } catch (\Exception $e) {
            $code = $e->getCode() === 403 ? 403 : 422;
            return response()->json(['message' => $e->getMessage()], $code);
        }
    }


public function index(Service $service): JsonResponse
{
    abort_if($service->status !== 'approved', 404);

    $ratings = $this->ratingService->getServiceRatings($service);
    $summary = $this->ratingService->getAverageRating($service);

    return RatingResource::collection($ratings)
        ->additional([
            'message' => __('rating.list_retrieved'),
            'summary' => $summary,
        ])
        ->response();
}
}
