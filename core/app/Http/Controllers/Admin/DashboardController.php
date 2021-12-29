<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Spatie\Analytics\Period;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Spatie\Analytics\AnalyticsFacade as Analytics;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('needs.not.page.selected');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $analyticsDataResume = $this->getAnalyticsDataResume();
        $analyticsDataPeriod = $this->getAnalyticsDataPeriod();        
    
        return view('admin.dashboard.index', compact('analyticsDataResume', 'analyticsDataPeriod'));
    }

    private function ensureAnalyticsCredentialsExists()
    {
        return !is_null(config('analytics.view_id')) && File::exists(config('analytics.service_account_credentials_json'));
    }

    private function getAnalyticsDataResume()
    {
        if(!$this->ensureAnalyticsCredentialsExists()) {
            return collect([]);
        }

        $analyticsData = Analytics::performQuery(
            Period::months(1),
            'ga:sessions, ga:pageviews, ga:users, ga:bounceRate'
        );

        $analyticsData = collect($analyticsData->getTotalsForAllResults() ?? [])->map(function ($dateRow, $key) {
            switch ($key) {
                case 'ga:sessions':
                    return number_format($dateRow, 0, '', '.');
                    break;
                case 'ga:pageviews':
                    return number_format($dateRow, 0, '', '.');
                    break;
                case 'ga:users':
                    return number_format($dateRow, 0, '', '.');
                    break;
                case 'ga:bounceRate':
                    return (int) round($dateRow);
                    break;
            }
        });

        return $analyticsData;
    }

    private function getAnalyticsDataPeriod()
    {
        if(!$this->ensureAnalyticsCredentialsExists()) {
            return collect([]);
        }

        $analyticsDataCurrent = Analytics::performQuery(
            Period::create(Carbon::now()->subDays(request()->query('period', 7) - 1), Carbon::now()),
            'ga:pageviews',
            [
                'metrics' => 'ga:pageviews',
                'dimensions' => 'ga:dayOfWeek, ga:date'
            ]
        );

        $analyticsDataCurrent = collect($analyticsDataCurrent['rows'] ?? [])->map(function (array $dateRow) {
            $date = Carbon::createFromFormat('Ymd', $dateRow[1]);
            return [
                'dayOfWeek' => ucfirst($date->shortDayName) . ' (' . $date->format('d/m/Y') . ')',
                'date' => $date,
                'pageViews' => $dateRow[2],
            ];
        })->sortBy('date')->map(function ($item) {
            $item['date'] = $item['date']->format('d/m/Y');
            return $item;
        });

        $analyticsData = collect([]);

        $analyticsData
        ->put('labels', $analyticsDataCurrent->pluck('dayOfWeek')->toArray())
        ->put('datasets', [
            [
                'label' => 'Visualização de páginas',
                'backgroundColor' => 'rgba(246, 246, 246, 0.5)',
                'borderColor' => '#2196f3',
                'pointBackgroundColor' => '#1976d2',
                'borderWidth' => '2',
                'data' => $analyticsDataCurrent->pluck('pageViews')->toArray()
            ]
        ]);

        return $analyticsData;
    }
}
