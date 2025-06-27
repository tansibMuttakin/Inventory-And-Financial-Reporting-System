<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            $from = $request->input('from');
            $to = $request->input('to');

            $salesQuery = Sale::with('product');

            if ($from && $to) {
                $salesQuery->whereBetween('created_at', [$from, $to]);
            }

            $sales = $salesQuery->get();

            $totalSales = $sales->sum('total'); // includes VAT

            $totalExpenses = $sales->sum(function ($sale) {
                return $sale->product->purchase_price * $sale->quantity;
            });

            $profit = $totalSales - $totalExpenses;

            return response()->json([
                'from' => $from,
                'to' => $to,
                'total_sales' => round($totalSales, 2),
                'total_expenses' => round($totalExpenses, 2),
                'profit' => round($profit, 2),
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }
}
