<?php

namespace App\Providers;

use App\Models\Statistic;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('pengaduan', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));
        View::composer(['pages.index', 'pages.informasi'], function ($view): void {
            $latestYear = Statistic::query()->where('status', 'aktif')->where('tampil_di_ringkasan', true)
                ->whereHas('category', fn ($query) => $query->where('status', true)->where(fn ($pageQuery) => $pageQuery->whereNull('page_id')->orWhereHas('page', fn ($statisticPageQuery) => $statisticPageQuery->where('status', true))))
                ->max('tahun');
            $publicStatistics = $latestYear
                ? Statistic::query()->where('status', 'aktif')->where('tampil_di_ringkasan', true)->where('tahun', $latestYear)
                    ->whereHas('category', fn ($query) => $query->where('status', true)->where(fn ($pageQuery) => $pageQuery->whereNull('page_id')->orWhereHas('page', fn ($statisticPageQuery) => $statisticPageQuery->where('status', true))))->get()->keyBy('slug')
                : collect();

            $view->with('publicStatistics', $publicStatistics);
        });
    }
}
