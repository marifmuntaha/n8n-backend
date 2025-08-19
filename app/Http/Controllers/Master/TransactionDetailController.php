<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\TransactionDetail;
use Exception;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    public function index(Request $request)
    {
        $transactionDetails = new TransactionDetail();
        $transactionDetails = $transactionDetails->limit(100)
            ->where('tgl_trans_dtl', '<=', date('Y-m-d'))
            ->orderBy('tgl_trans_dtl', 'desc')
            ->get();
        return response([
            'results' => $transactionDetails
        ]);
    }

    public function store(Request $request)
    {
        try {

            return ($transactionDetails = TransactionDetail::create($request->all()))
                ? response([
                    'results' => $transactionDetails,
                    'message' => 'Data Transaksi berhasil disimpan!'
                ]) : throw new Exception('Data Transaksi gagal disimpan!');
        } catch (Exception $e) {
            return response([
                'results' => $e->getMessage()
            ], 422);
        }
    }

    public function show(TransactionDetail $transactionDetail)
    {
        return response([
            'results' => $transactionDetail
        ]);
    }

    public function update(Request $request, TransactionDetail $transactionDetail)
    {
        try {
            return ($transactionDetail->update($request->all()))
                ? response([
                    'results' => $transactionDetail,
                    'message' => 'Data Transaksi berhasil diupdate!'
                ]) : throw new Exception('Data Transaksi gagal diupdate!');
        } catch (Exception $e) {
            return response([
                'results' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy(TransactionDetail $transactionDetail)
    {
        try {
            return $transactionDetail->delete()
                ? response([
                    'results' => $transactionDetail,
                    'message' => 'Data Transaksi berhasil dihapus!'
                ]) : throw new Exception('Data Transaksi gagal dihapus!');
        } catch (Exception $e) {
            return response([
                'results' => $e->getMessage()
            ], 422);
        }
    }
}
