<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreReportRequest;
use App\Models\Service;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    public function __construct(protected ReportService $reportService)
    {
    }

    public function store(StoreReportRequest $request, Service $service): JsonResponse
    {
        $report = $this->reportService->submit(
            $request->user(),
            $service,
            $request->validated('reason')
        );

        return response()->json([
            'status'  => true,
            'message' => __('reports.submitted'),
            'data'    => [
                'id'     => $report->id,
                'reason' => $report->reason,
            ],
        ], 201);
    }
}
