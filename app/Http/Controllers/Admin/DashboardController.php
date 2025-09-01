<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Celebrity;
use App\Models\Competition;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\Project;
use App\Models\Sale;
use App\Models\SaleCelebrity;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        Carbon::setWeekStartsAt(Carbon::SATURDAY);
        Carbon::setWeekEndsAt(Carbon::FRIDAY);
    }

    public function index()
    {
        $title = trans('admin.Dashboard');

        $allUsers = User::count();
        $teamCount = Team::whereStatus(1)->count();
        $projectsCount = Project::whereStatus(1)->count();
        $servicesCount = Service::whereStatus(1)->count();


        $ordersChart = DB::table('orders')->whereYear('created_at', date('Y'))->get()
            ->groupBy(function ($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->created_at)->format('m'); // grouping by months
            });
        $ordermcount = [];
        $orderArr = [];
        foreach ($ordersChart as $key => $value) {
            $ordermcount[(int)$key] = count($value);
        }
        for ($i = 1; $i <= 12; $i++) {
            if (!empty($ordermcount[$i])) {
                $orderArr[$i] = $ordermcount[$i];
            } else {
                $orderArr[$i] = 0;
            }
        }

        return view('admin.dashboard.new', get_defined_vars());
    }
}
