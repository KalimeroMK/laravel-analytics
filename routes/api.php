<?php

use Illuminate\Support\Facades\Route;
use WdevRs\LaravelAnalytics\Http\Controllers\AnalyticsController;

Route::get('analytics/page-views-per-days', [AnalyticsController::class, 'getPageViewsPerDays']);
Route::get('analytics/page-views-per-path', [AnalyticsController::class, 'getPageViewsPerPaths']);

// New routes for additional analytics methods
Route::get('analytics/page-views-last-28-days', [AnalyticsController::class, 'getPageViewsLast28Days']);
Route::get('analytics/page-views-last-3-months', [AnalyticsController::class, 'getPageViewsLast3Months']);
Route::get('analytics/page-views-last-6-months', [AnalyticsController::class, 'getPageViewsLast6Months']);
Route::get('analytics/page-views-last-year', [AnalyticsController::class, 'getPageViewsLastYear']);
Route::get('analytics/page-views-custom-range', [AnalyticsController::class, 'getPageViewsCustomRange']);