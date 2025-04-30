<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->take(5)->get();

        $dashboardDatas = DB::select("SELECT
                        SUM(total) AS TotalAmount,
                        SUM(IF(status = 'ordered', total, 0)) AS TotalOrderedAmount,
                        SUM(IF(status = 'delivered', total, 0)) AS TotalDeliveredAmount,
                        SUM(IF(status = 'canceled', total, 0)) AS TotalCanceledAmount,
                        COUNT(*) AS Total,
                        SUM(IF(status = 'ordered', 1, 0)) AS TotalOrdered,
                        SUM(IF(status = 'delivered', 1, 0)) AS TotalDelivered,
                        SUM(IF(status = 'canceled', 1, 0)) AS TotalCanceled
                    FROM orders");

        // Create month names array if month_names table doesn't exist
        $monthlyDatas = DB::select("SELECT
                            MONTH(created_at) AS MonthNo,
                            DATE_FORMAT(created_at, '%b') AS MonthName,
                            SUM(total) AS TotalAmount,
                            SUM(IF(LOWER(status)='ordered', total, 0)) AS TotalOrderedAmount,
                            SUM(IF(LOWER(status)='delivered', total, 0)) AS TotalDeliveredAmount,
                            SUM(IF(LOWER(status)='canceled', total, 0)) AS TotalCanceledAmount
                        FROM
                            orders
                        WHERE
                            YEAR(created_at) = YEAR(NOW())
                        GROUP BY
                            YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
                        ORDER BY
                            MONTH(created_at)");

        // Ensure we have all 12 months
        $allMonths = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('M', mktime(0, 0, 0, $i, 1));
            $found = false;

            foreach ($monthlyDatas as $data) {
                if ($data->MonthNo == $i) {
                    $allMonths[] = $data;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $allMonths[] = (object)[
                    'MonthNo' => $i,
                    'MonthName' => $monthName,
                    'TotalAmount' => 0,
                    'TotalOrderedAmount' => 0,
                    'TotalDeliveredAmount' => 0,
                    'TotalCanceledAmount' => 0
                ];
            }
        }

        $AmountM = implode(',', array_column($allMonths, 'TotalAmount'));
        $OrderedAmountM = implode(',', array_column($allMonths, 'TotalOrderedAmount'));
        $DeliveredAmountM = implode(',', array_column($allMonths, 'TotalDeliveredAmount'));
        $CanceledAmountM = implode(',', array_column($allMonths, 'TotalCanceledAmount'));

        $TotalAmount = array_sum(array_column($allMonths, 'TotalAmount'));
        $TotalOrderedAmount = array_sum(array_column($allMonths, 'TotalOrderedAmount'));
        $TotalDeliveredAmount = array_sum(array_column($allMonths, 'TotalDeliveredAmount'));
        $TotalCanceledAmount = array_sum(array_column($allMonths, 'TotalCanceledAmount'));

        return view('admin.index', compact(
            'orders',
            'dashboardDatas',
            'allMonths',
            'AmountM',
            'OrderedAmountM',
            'DeliveredAmountM',
            'CanceledAmountM',
            'TotalAmount',
            'TotalOrderedAmount',
            'TotalDeliveredAmount',
            'TotalCanceledAmount'
        ));
    }
}