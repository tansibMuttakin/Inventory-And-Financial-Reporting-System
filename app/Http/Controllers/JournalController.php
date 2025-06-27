<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $query = Journal::with('sale')->latest();

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('from') && $request->has('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        return $query->get();
    }

    public function summary(Request $request)
    {
        $types = ['sales', 'discount', 'vat', 'payment_cash', 'payment_due'];

        $summary = [];

        foreach ($types as $type) {
            $query = Journal::where('type', $type);

            if ($request->has('from') && $request->has('to')) {
                $query->whereBetween('created_at', [$request->from, $request->to]);
            }

            $summary[$type] = $query->sum('amount');
        }

        return response()->json($summary);
    }
}
