<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mostOrders()
    {
        $data['MostOrdersByCustomer'] = DB::table('orders')
            ->select('orders.orderNumber', 'orders.orderDate', DB::raw("COUNT(orders.customerNumber) as TotalOrdersByCustomer"), 'orders.customerNumber', 'customers.customerName', 'orderdetails.quantityOrdered')
            ->leftJoin('customers', 'customers.customerNumber', '=', 'orders.customerNumber')
            ->leftJoin('orderdetails', 'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->groupBy('orders.customerNumber')
            ->orderBy('TotalOrdersByCustomer', 'desc')
            ->first();
        echo json_encode($data);
    }

    public function mostSpents()
    {
        $data['MostSpentByCustomer'] = DB::table('orders')
            ->select('orders.orderNumber', 'orders.orderDate', DB::raw("SUM(orderdetails.priceEach) as TotalSpentByCustomer"), 'orders.customerNumber', 'customers.customerName')
            ->leftJoin('customers', 'customers.customerNumber', '=', 'orders.customerNumber')
            ->leftJoin('orderdetails', 'orderdetails.orderNumber', '=', 'orders.orderNumber')
            ->groupBy('orders.orderNumber')
            ->orderBy('TotalSpentByCustomer', 'desc')
            ->first();
        echo json_encode($data);
    }
}
