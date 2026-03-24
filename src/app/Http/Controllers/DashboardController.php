<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardStatisticsRequest;
use App\Http\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService)
    {

    }

    public function metrics(): array
    {
        return $this->dashboardService->metrics();
    }

    public function statistics(DashboardStatisticsRequest $request): array
    {
        return $this->dashboardService->statistics($request->validated());
    }
}
