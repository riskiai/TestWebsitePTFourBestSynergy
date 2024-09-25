<?php

namespace App\Http\Controllers\Customer;

use App\Models\Role;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DataQueuing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Antrian\QueueRequest;
use Illuminate\Support\Facades\Log;

class QueuesController extends Controller
{
    /* Data Pengambilan Tiket */
    public function formTiket() {
        return view('customer.formTiket');
    }

    public function formTiketProsess(QueueRequest $request) {
        Log::info('Proses pengambilan tiket dimulai.');
        Log::info('Data yang diterima: ', $request->all());
    
        // Cari user berdasarkan nomor polisi
        $user = User::where('username', $request->no_polisi)->first();
        Log::info('User ditemukan: ' . ($user ? 'Ya' : 'Tidak'));
    
        if (!$user) {
            Log::info('User tidak ditemukan, proses pembuatan user baru.');
            if ($request->filled(['name', 'address', 'phone_number'])) {
                Log::info('Data pelanggan lengkap, membuat user baru.');
    
                $roleCustomer = Role::where('role_name', 'customer')->first();
                $user = User::create([
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone_number' => $request->phone_number,
                    'username' => $request->no_polisi,
                    'password' => bcrypt('defaultpassword'),
                    'role_id' => $roleCustomer->id,
                ]);
            } else {
                Log::info('Data pelanggan tidak lengkap, redirect ke form dengan pesan.');
                return redirect()->route('formTiket')->with('info', 'Mohon lengkapi data pelanggan.');
            }
        }
    
        // Hitung nomor antrian berdasarkan jenis antrian (GR atau BP)
        $queueNumber = DataQueuing::where('jenis_antrian', $request->jenis_antrian)->count() + 1;
    
        // Buat antrian baru
        $queue = DataQueuing::create([
            'user_id' => $user->id,
            'no_polisi' => $request->no_polisi,
            'jenis_antrian' => $request->jenis_antrian,
            'status' => 'waiting',
        ]);
    
        if ($queue) {
            Log::info('Antrian berhasil dibuat dengan ID: ' . $queue->id);
    
            // Simpan nomor urut ke dalam sesi untuk cetak
            session()->put('queue', $queue);
            session()->put('queue_id', $queue->id);
            session()->put('queue_number', $queueNumber); // Simpan nomor antrian dalam sesi
    
            return redirect()->route('formTiket')->with('success', 'Tiket berhasil diambil. Tunggu nomor antrian Anda dipanggil.');
        } else {
            Log::error('Gagal membuat antrian untuk nomor polisi: ' . $request->no_polisi);
            return redirect()->route('formTiket')->with('error', 'Gagal mengambil tiket. Silakan coba lagi.');
        }
    }
    

    // Metode untuk mengecek apakah nomor polisi sudah terdaftar
    public function checkNoPolisi(Request $request)
    {
        $user = User::where('username', $request->no_polisi)->first();
    
        if ($user) {
            // Kembalikan data pengguna jika ditemukan
            return response()->json([
                'exists' => true,
                'name' => $user->name,
                'address' => $user->address,
                'phone_number' => $user->phone_number,
            ]);
        } else {
            return response()->json(['exists' => false]);
        }
    }
    

    // Method untuk mencetak tiket antrian
    public function printTicket($id)
    {
        Log::info('Proses mencetak tiket dengan ID: ' . $id);

        // Ambil data antrian berdasarkan ID
        $queue = DataQueuing::with('user')->find($id);

        if (!$queue) {
            Log::error('Tiket tidak ditemukan untuk ID: ' . $id);
            return redirect()->back()->with('error', 'Tiket tidak ditemukan');
        }

        // Generate PDF dari view dengan ukuran kertas kecil
        $pdf = Pdf::loadView('customer.printTicket', compact('queue'))
               ->setPaper([0, 0, 200, 400]); // Atur ukuran kertas kecil

        return $pdf->stream('tiket_antrian_' . $queue->id . '.pdf');
    }

    /* Data Antrian */
    public function getDataAntrian()
    {
        $countGR = DataQueuing::where('jenis_antrian', 'GR')->where('status', 'called')->count();
        $countBP = DataQueuing::where('jenis_antrian', 'BP')->where('status', 'called')->count();

        return view('customer.dataAntrian', compact('countGR', 'countBP'));
    }
}
