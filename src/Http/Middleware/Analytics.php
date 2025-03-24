<?php

namespace WdevRs\LaravelAnalytics\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Throwable;
use WdevRs\LaravelAnalytics\Models\PageView;

class Analytics
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            if (!$this->shouldTrack($request)) {
                return $response;
            }

            $this->storePageView($request);
        } catch (Throwable $e) {
            report($e);
        }

        return $response;
    }

    private function shouldTrack(Request $request): bool
    {
        if (!$request->isMethod('GET') || $request->isJson()) {
            return false;
        }

        $userAgent = $request->userAgent();
        if (is_null($userAgent) || app(CrawlerDetect::class)->isCrawler($userAgent)) {
            return false;
        }

        return true;
    }

    private function storePageView(Request $request): void
    {
        $pageView = new PageView([
            'session_id' => session()->getId(),
            'path' => $request->path(),
            'user_agent' => Str::limit($request->userAgent(), 255),
            'ip' => $request->header('X-Forwarded-For', $request->ip()),
            'referer' => $request->header('referer'),
        ]);

        if ($model = $this->getRouteModel($request)) {
            $pageView->pageModel()->associate($model);
        }

        $pageView->save();
    }

    private function getRouteModel(Request $request): ?Model
    {
        $parameters = $request->route()?->parameters();
        $model = $parameters ? reset($parameters) : null;

        return $model instanceof Model ? $model : null;
    }
}
