<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Whatsapp;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WhatsappController extends Controller
{
    public function index(Request $request)
    {
        if ($client = Whatsapp::whereWhatsappid($request->whatsappId)->first()) {
            if ($client->session == '0') {
                if($student = Student::where('NIS', $request->message)->first()){
                    if ($student->STATUS == '1') {
                        $client->session = '1';
                        $client->studentId = $student->NIS;
                        $client->save();
                        $message = 'Selamat Datang *'. $student->NAMA_SISWA .'*. '.PHP_EOL.'Silahkan ketikkan "*menu*" kemudian kirim untuk memulai akses bot';
                        return response()->json([
                            'message' => $message
                        ]);
                    } else {
                        return response()->json([
                            'message' => 'Anda sudah alumni/sudah keluar dari lembaga.'.PHP_EOL.'Silahkan masukkan NIS yang lgi'
                        ]);
                    }
                } else {
                    return response()->json([
                        'message' => 'NIS tidak ditemukan.'.PHP_EOL.'Silahkan masukkan NIS yang benar'
                    ]);
                }
            }
            else if($client->session == '1') {
                if ($request->message == 'menu' || $request->message == '0') {
                    return $this->messageSession1();
                }
                else if ($request->message == '1') {
                    $message = "*Informasi Siswa*" . PHP_EOL;
                    $message .= 'Nama: '.$client->student->NAMA_SISWA . PHP_EOL;
                    $message .= 'NIS: '.$client->student->NIS . PHP_EOL;
                    $message .= 'Kelas: '.$client->student->KELAS . PHP_EOL;
                    $message .= 'Alamat: '.$client->student->ALAMAT . PHP_EOL;
                    $message .= 'Jenis Kelamin: '. $client->student->JNS_KELAMIN . PHP_EOL;
                    $message .= 'Tempat Lahir: '. $client->student->TEMPATLAHIR . PHP_EOL;
                    $message .= 'Tanggal Lahir: '. Carbon::parse($client->student->TGLLAHIR)->translatedFormat('d F Y') . PHP_EOL;
                    $message .= 'Nama Wali: '. $client->student->WALI_MURID . PHP_EOL;
                    $message .= 'Telp Wali: '. $client->student->TELPON_WALI . PHP_EOL;
                    $message .= 'Nama Ayah: '. $client->student->NAMA_AYAH . PHP_EOL;
                    $message .= 'Nama Ibu: '. $client->student->NAMA_IBU . PHP_EOL;
                    $message .= 'Tabungan: '. number_format($client->student->SALDO_TABUNGAN) . PHP_EOL;
                    $message .= 'Tagihan: '. number_format($client->student->TAGIHAN_BIAYA) . PHP_EOL;
                    $message .= 'Boarding: '. $client->student->BOARDING . PHP_EOL;
                    $message .= 'Program: '. $client->student->SUBBOARDING . PHP_EOL;
                    $message .= 'Transaksi : '. json_encode($this->transaction($client->student));
                    return response()->json([
//                        'message' => $message . PHP_EOL.'0. Kembali'
                        $this->transaction($client->student),
                    ]);
                }
                else if ($request->message == '3') {
                    $client->session = '2';
                    $client->save();
                    $message = $client->student->NAMA_SISWA. ', anda memiliki tagihan sebesar : ' .number_format($client->student->TAGIHAN_BIAYA) . PHP_EOL;
                    $message .= 'Pilih menu Pembayaran :'.PHP_EOL;
                    $message .= '1. Buat Pembayaran.'. PHP_EOL;
                    $message .= '2. Lihat Kode Bayar.'. PHP_EOL;
                    $message .= '3. Lihat Status Pembayaran.'. PHP_EOL;
                    $message .= '4. Riwayat Pembayaran.'. PHP_EOL;
                    return response()->json([
                        'message' => $message. PHP_EOL.'0. Kembali Menu Utama'
                    ]);
                }
                else if ($request->message == '4') {
                    $client->delete();
                    return response()->json([
                        'message' => 'Anda Berhasil Keluar.'.PHP_EOL.'Silahkan masukkan NIS anda :'
                    ]);
                }
                else {
                    return $this->messageSession1();
                }
            }
            else if($client->session == '2') {
                if ($request->message == '1') {
                    $client->session = '3';
                    $client->save();
                    $message = 'Silahkan masukkan Nominal Pembayaran :';
                    return response()->json([
                        'message' => $message
                    ]);
                }
                else if ($request->message == '4') {
                    $transaction = collect($client->student->transaction()
                        ->where('MY_KODE_TRANS', 200)
                        ->limit(5)
                        ->orderBy('TGL_TRANS', 'desc')
                        ->get()->toArray());
                    $response = '';
                    $transaction->map(function ($item) use (&$response) {
                        $response .= 'Tanggal : '. $item['TGL_TRANS'] . PHP_EOL;
                        $response .= 'Nominal : '. number_format($item['SALDO_TRANS']) . PHP_EOL;
                        $response .= 'Keterangan : '. $item['KETERANGAN'] . PHP_EOL . PHP_EOL;
                    });
                    return response()->json([
                        'message' => $response . '0. Kembali Menu Utama'
                    ]);
                }
                else if ($request->message == '0') {
                    $client->session = '1';
                    $client->save();
                    return $this->messageSession1();
                }
                else {
                    $student = 'Pilih menu Pembayaran :'.PHP_EOL;
                    $student .= '1. Buat Pembayaran.'. PHP_EOL;
                    $student .= '2. Lihat Kode Bayar.'. PHP_EOL;
                    $student .= '3. Lihat Status Pembayaran.'. PHP_EOL;
                    $student .= '4. Riwayat Pembayaran.'. PHP_EOL;
                    return response()->json([
                        'message' => $student . PHP_EOL.'0. Kembali Menu Utama'
                    ]);
                }
            }
            else {
                return response()->json([
                    'message' => 'Silahkan masukkan NIS anda :'
                ]);
            }
        } else {
            Whatsapp::create([
                'whatsappId' => $request->whatsappId,
                'session' => '0',
                'studentId' => null,
            ]);
            return response()->json([
                'message' => 'Selamat Datang di Whatsapp-bot Yayasan Darul Hikmah Menganti. '.PHP_EOL.'Silahkan masukkan NIS anda :'
            ]);
        }
    }

    private function messageSession1()
    {
        return response()->json([
            'message' => ' Silahkan pilih menu dibawah ini :'.PHP_EOL.'1. Informasi Pribadi'.PHP_EOL.'2. Informasi Tagihan'.PHP_EOL.'3. Pembayaran'.PHP_EOL.'4. Keluar'
        ]);
    }

    private function transaction($student)
    {
        $transaction = $student->transaction()
            ->where('NIS', $student->NIS)
            ->whereBetween('TGL_TRANS', [Carbon::now()->addYear(-1), Carbon::now()]);
        $invoice =  $transaction->where('MY_KODE_TRANS', 100)->orderBy('TGL_TRANS', 'desc')->get()->sum('SALDO_TRANS');
//        $payment =  $student->transaction()->where('TGL_TRANS', '<=' ,Carbon::now()->format('YYYY-MM-DD'))->where('MY_KODE_TRANS', 200)->orderBy('TGL_TRANS', 'desc')->get()->sum('SALDO_TRANS');
        return (object)[
            'invoice' => $invoice,
//            'payment' => $payment,
//            'lastInvoice' => $invoice - $payment
        ];
    }
}
