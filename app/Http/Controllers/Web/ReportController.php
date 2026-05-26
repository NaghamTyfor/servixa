<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ReportController extends Controller
{
    public function __construct(protected ReportService $reportService)
    {
    }

    public function index(Request $request): View
    {
        $search  = $request->input('search');
        $reports = $this->reportService->searchAndPaginate($search, 15);

        return view('admin.reports.index', [
            'reports'     => $reports,
            'catName'     => 'reports',
            'title'       => __('admin.reports'),
            'breadcrumbs' => [__('admin.reports_management')],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }

    public function show(Report $report): View
    {
        $report->load(['user', 'service.businessAccount']);

        return view('admin.reports.show', [
            'report'      => $report,
            'catName'     => 'reports',
            'title'       => __('admin.report_details'),
            'breadcrumbs' => [__('admin.dashboard'), __('admin.reports'), '#' . $report->id],
            'scrollspy'   => 0,
            'simplePage'  => 0,
        ]);
    }


}
