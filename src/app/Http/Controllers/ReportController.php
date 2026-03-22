<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportRequest;
use App\Http\Services\ReportService;

class ReportController extends Controller
{
    public function __construct(
        private readonly ReportService $reportService
    ) {}

    public function stats()
    {
        return response()->json($this->reportService->stats());
    }

    public function generate(ReportRequest $request)
    {
        return $this->reportService->generateReport($request->validated());
    }
}
