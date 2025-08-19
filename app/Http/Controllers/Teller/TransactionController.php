<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use App\Models\Teller\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = new Transaction();
        $transactions = $transactions->limit(100)
            ->where('tgl_trans', '<=', Carbon::now()->format('Y-m-d'))
            ->orderBy('modul_trans_id', 'desc')
            ->get();
        return response([
            'result' => $transactions
        ]);
    }

    public function store(Request $request)
    {
        try {
            return ($transaction = Transaction::create($request->all()))
                ? response([
                    'result' => $transaction,
                    'message' => 'Transaction created successfully!'
                ]) : throw new Exception('Failed to create transaction!');
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show(Transaction $transaction)
    {
        return response([
            'result' => $transaction
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        try {
            return ($transaction->update($request->all()))
                ? response([
                    'result' => $transaction,
                    'message' => 'Transaction updated successfully!'
                ]) : throw new Exception('Failed to update transaction!');
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy(Transaction $transaction)
    {
        try {
            return ($transaction->delete())
                ? response([
                    'result' => $transaction,
                    'message' => 'Transaction deleted successfully!'
                ]) : throw new Exception('Failed to delete transaction!');
        } catch (Exception $e) {
            return response([
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
