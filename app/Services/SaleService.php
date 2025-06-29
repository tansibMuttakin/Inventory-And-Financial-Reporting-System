<?php
namespace App\Services;

use App\Models\Sale;
use App\Models\Journal;

class SaleService
{

    public static function createJournalOnSale($sale_id, $subTotal, $vat, $validated, $due)
    {
        Journal::create(['sale_id' => $sale_id, 'type' => 'sales', 'amount' => $subTotal]);
        Journal::create(['sale_id' => $sale_id, 'type' => 'discount', 'amount' => $validated['discount'] ?? 0]);
        Journal::create(['sale_id' => $sale_id, 'type' => 'vat', 'amount' => $vat]);

        if ($validated['paid_amount'] > 0) {
            Journal::create(['sale_id' => $sale_id, 'type' => 'payment_cash', 'amount' => $validated['paid_amount']]);
        }

        if ($due > 0) {
            Journal::create(['sale_id' => $sale_id, 'type' => 'payment_due', 'amount' => $due]);
        }
    }
}