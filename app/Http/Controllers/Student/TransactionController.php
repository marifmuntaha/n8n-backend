<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student\Transaction;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = new Transaction();
        $transactions = $transactions->limit(100)
            ->where('MY_KODE_TRANS', 200)
            ->orderBy('TGL_TRANS', 'desc')
            ->get();
        return response()->json([
            'result' => $transactions
        ]);
    }

    public function store(Request $request)
    {
        try {
            return ($transaction = Transaction::create($request->all()))
                ? response()->json([
                    'result' => $transaction,
                    'message' => 'Data Transaksi berhasil disimpan!'
                ])
                : throw new Exception('Data Transaksi gagal disimpan!');
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function show(Transaction $transaction)
    {
        return response()->json([
            'result' => $transaction
        ]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        try {
            return ($transaction->update($request->all()))
                ? response()->json([
                    'result' => $transaction,
                    'message' => 'Data Transaksi berhasil diupdate!'
                ]) : throw new Exception('Data Transaksi gagal diupdate!');
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy(Transaction $transaction)
    {
        try {
            return ($transaction->delete())
                ? response()->json([
                    'result' => $transaction,
                ]) : throw new Exception('Data Transaksi gagal dihapus!');
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
