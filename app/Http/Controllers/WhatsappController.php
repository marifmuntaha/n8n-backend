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
                    $client->session = '1';
                    $client->studentId = $student->NIS;
                    $client->save();
                    return response()->json([
                        'message' => 'Selamat Datang *'. $student->NAMA_SISWA .'*. '.PHP_EOL.'Silahkan ketikkan *menu* untuk memulai akses bot'
                    ]);
                } else {
                    return response()->json([
                        'message' => 'NIS tidak ditemukan.'.PHP_EOL.'Silahkan masukkan NIS yang benar'
                    ]);
                }
            } else if($client->session == '1') {
                if ($request->message == 'menu' || $request->message == '0') {
                    return $this->messageSession1();
                }
                if ($request->message == '1') {
                    $student = 'Nama: '.$client->student->NAMA_SISWA . PHP_EOL;
                    $student .= 'NIS: '.$client->student->NIS . PHP_EOL;
                    $student .= 'Kelas: '.$client->student->KELAS . PHP_EOL;
                    $student .= 'Alamat: '.$client->student->ALAMAT . PHP_EOL;
                    $student .= 'Jenis Kelamin: '. $client->student->JNS_KELAMIN . PHP_EOL;
                    $student .= 'Tempat Lahir: '. $client->student->TEMPATLAHIR . PHP_EOL;
                    $student .= 'Tanggal Lahir: '. Carbon::parse($client->student->TGLLAHIR)->translatedFormat('d F Y') . PHP_EOL;
                    $student .= 'Nama Wali: '. $client->student->WALI_MURID . PHP_EOL;
                    $student .= 'Telp Wali: '. $client->student->TELPON_WALI . PHP_EOL;
                    $student .= 'Nama Ayah: '. $client->student->NAMA_AYAH . PHP_EOL;
                    $student .= 'Nama Ibu: '. $client->student->NAMA_IBU . PHP_EOL;
                    $student .= 'Tabungan: '. number_format($client->student->SALDO_TABUNGAN) . PHP_EOL;
                    $student .= 'Tagihan: '. number_format($client->student->TAGIHAN_BIAYA) . PHP_EOL;
                    $student .= 'Boarding: '. $client->student->BOARDING . PHP_EOL;
                    $student .= 'Program: '. $client->student->SUBBOARDING . PHP_EOL;
                    return response()->json([
                        'message' => $student . PHP_EOL.'0. Kembali'
                    ]);
                }
                if ($request->message == '3') {
                    $client->session = '2';
                    $client->save();
                    $student = $client->student->NAMA_SISWA. ', anda memiliki tagihan sebesar : ' .number_format($client->student->TAGIHAN_BIAYA) . PHP_EOL;
                    $student .= 'Pilih menu Pembayaran :'.PHP_EOL;
                    $student .= '1. Buat Pembayaran.'. PHP_EOL;
                    $student .= '2. Lihat Kode Bayar.'. PHP_EOL;
                    $student .= '3. Lihat Status Pembayaran.'. PHP_EOL;
                    $student .= '4. Riwayat Pembayaran.'. PHP_EOL;
                    return response()->json([
                        'message' => $student . PHP_EOL.'0. Kembali Menu Utama'
                    ]);
                }
                if($request->message == '4') {
                    $client->delete();
                    return response()->json([
                        'message' => 'Anda Berhasil Keluar.'.PHP_EOL.'Silahkan masukkan NIS anda :'
                    ]);
                }
            } else if($client->session == '2') {
                if ($request->message == '4') {
                    $transaction = collect($client->student->transaction()
                        ->where('MY_KODE_TRANS', 200)
                        ->limit(5)
                        ->orderBy('TGL_TRANS', 'desc')
                        ->get()->toArray());
                    $response = '';
                    $transaction->map(function ($item) use (&$response) {
                        $response .= 'Tanggal : '. $item->TGL_TRANS . PHP_EOL;
                    });
                    return response()->json([
                        'message' => $response
                    ]);
                }
                if ($request->message == '0') {
                    $client->session = '1';
                    $client->save();
                    return $this->messageSession1();
                }
            } else {
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
                'message' => 'Selamat Datang di Whatsapp-Bot Yayasan Darul Hikmah Menganti. '.PHP_EOL.'Silahkan masukkan NIS anda :'
            ]);
        }
    }

    private function messageSession1()
    {
        return response()->json([
            'message' => ' Silahkan pilih menu dibawah ini :'.PHP_EOL.'1. Informasi Pribadi'.PHP_EOL.'2. Informasi Tagihan'.PHP_EOL.'3. Pembayaran'.PHP_EOL.'4. Keluar'
        ]);
    }
}
