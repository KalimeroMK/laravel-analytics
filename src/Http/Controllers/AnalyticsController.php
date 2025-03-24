<?php

namespace WdevRs\LaravelAnalytics\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use WdevRs\LaravelAnalytics\Repositories\PageViewRepository;

class AnalyticsController extends Controller
{
    protected PageViewRepository $pageViewRepository;

    public function __construct(PageViewRepository $pageViewRepository)
    {
        $this->pageViewRepository = $pageViewRepository;
    }

    public function getPageViewsPerDays(): JsonResponse
    {
        return response()->json(
            $this->pageViewRepository->getByDateGroupedByDays(Carbon::today()->subDays(28))
        );
    }

    public function getPageViewsPerPaths(): JsonResponse
    {
        return response()->json(
            $this->pageViewRepository->getByDateGroupedByPath(Carbon::today()->subDays(28))
        );
    }

    public function getPageViewsLast28Days(): JsonResponse
    {
        return response()->json(
            $this->pageViewRepository->getLast28Days()
        );
    }

    public function getPageViewsLast3Months(): JsonResponse
    {
        return response()->json(
            $this->pageViewRepository->getLast3Months()
        );
    }

    public function getPageViewsLast6Months(): JsonResponse
    {
        return response()->json(
            $this->pageViewRepository->getLast6Months()
        );
    }

    public function getPageViewsLastYear(): JsonResponse
    {
        return response()->json(
            $this->pageViewRepository->getLastYear()
        );
    }

    public function getPageViewsCustomRange(Request $request): JsonResponse
    {
        $startDate = Carbon::parse($request->query('start_date', now()->subMonth()));
        $endDate = Carbon::parse($request->query('end_date', now()));

        return response()->json(
            $this->pageViewRepository->getCustomRange($startDate, $endDate)
        );
    }
}
