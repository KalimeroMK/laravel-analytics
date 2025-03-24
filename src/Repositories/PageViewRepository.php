<?php

namespace WdevRs\LaravelAnalytics\Repositories;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use WdevRs\LaravelAnalytics\Models\PageView;

class PageViewRepository
{
    public function getByDate(Carbon $date): Collection
    {
        return PageView::query()
            ->where('created_at', '>=', $date)
            ->get();
    }

    public function getByDateGroupedByPath(Carbon $date): Collection
    {
        return PageView::query()
            ->selectRaw('COUNT(id) as count, path')
            ->where('created_at', '>=', $date)
            ->groupBy('path')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'path');
    }

    public function getByDateGroupedByDays(Carbon $date): Collection
    {
        return PageView::query()
            ->selectRaw('DATE(created_at) as date, COUNT(id) as count')
            ->where('created_at', '>=', $date)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->pluck('count', 'date');
    }

    public function getVisitorsByDateGroupedByDays(Carbon $date): Collection
    {
        return PageView::query()
            ->selectRaw('DATE(created_at) as date, COUNT(DISTINCT session_id) as count')
            ->where('created_at', '>=', $date)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->pluck('count', 'date');
    }

    public function getLast28Days(): Collection
    {
        return $this->getByDateGroupedByDays(Carbon::today()->subDays(28));
    }

    public function getLast3Months(): Collection
    {
        return $this->getByDateGroupedByDays(Carbon::today()->subMonths(3));
    }

    public function getLast6Months(): Collection
    {
        return $this->getByDateGroupedByDays(Carbon::today()->subMonths(6));
    }

    public function getLastYear(): Collection
    {
        return $this->getByDateGroupedByDays(Carbon::today()->subYear());
    }

    public function getCustomRange(Carbon $startDate, Carbon $endDate): Collection
    {
        return PageView::query()
            ->selectRaw('DATE(created_at) as date, COUNT(id) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->pluck('count', 'date');
    }
}
