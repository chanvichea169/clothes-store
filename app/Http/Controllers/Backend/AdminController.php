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
                        SUM(IF(status = 'ORDERED', total, 0)) AS TotalOrderedAmount,
                        SUM(IF(status = 'DELIVERED', total, 0)) AS TotalDeliveredAmount,
                        SUM(IF(status = 'CANCELED', total, 0)) AS TotalCanceledAmount,
                        COUNT(*) AS Total,
                        SUM(IF(status = 'ORDERED', 1, 0)) AS TotalOrdered,
                        SUM(IF(status = 'DELIVERED', 1, 0)) AS TotalDelivered,
                        SUM(IF(status = 'CANCELED', 1, 0)) AS TotalCanceled
                    FROM orders");

        $monthlyDatas = DB::select("SELECT
                            M.id AS MonthNo,
                            M.name AS MonthName,
                            IFNULL(D.TotalAmount, 0) AS TotalAmount,
                            IFNULL(D.TotalOrderedAmount, 0) AS TotalOrderedAmount,
                            IFNULL(D.TotalDeliveredAmount, 0) AS TotalDeliveredAmount,
                            IFNULL(D.TotalCanceledAmount, 0) AS TotalCanceledAmount
                        FROM
                            month_names M
                        LEFT JOIN (
                            SELECT
                                DATE_FORMAT(created_at, '%b') AS MonthName,
                                MONTH(created_at) AS MonthNo,
                                SUM(total) AS TotalAmount,
                                SUM(IF(status='ordered', total, 0)) AS TotalOrderedAmount,
                                SUM(IF(status='delivered', total, 0)) AS TotalDeliveredAmount,
                                SUM(IF(status='canceled', total, 0)) AS TotalCanceledAmount
                            FROM
                                Orders
                            WHERE
                                YEAR(created_at) = YEAR(NOW())
                            GROUP BY
                                YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
                            ORDER BY
                                MONTH(created_at)
                        ) D
                        ON D.MonthNo = M.id;");


        $AmountM = implode(',', collect($monthlyDatas)->pluck('TotalAmount')->toArray());
        $OrderedAmountM = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $DeliveredAmountM = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $CanceledAmountM = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());


        $TotalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $TotalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $TotalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');

        return view('admin.index', compact(
            'orders',
            'dashboardDatas',
            'monthlyDatas',
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