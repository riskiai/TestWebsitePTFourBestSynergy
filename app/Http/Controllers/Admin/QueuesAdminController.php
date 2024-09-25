<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataQueuing;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class QueuesAdminController extends Controller
{
    /* Dashboard Admin */
    public function dashboard() {
        $queues = DataQueuing::with('user')->orderBy('created_at', 'desc')->paginate(10); 
        return view('admin.dashboard', compact('queues'));
    }

   /* Data Tiket Customer */
   public function datatiketcustomer(Request $request) {
    // Jika ini adalah request DataTables (AJAX)
    if ($request->ajax()) {
        $queues = DataQueuing::with('user')->orderBy('created_at', 'asc');
        return DataTables::of($queues)
            ->addColumn('action', function($queue){
                return '<button type="button" class="btn btn-danger btn-sm delete-button" data-bs-toggle="modal" data-id="'.$queue->id.'" data-bs-target="#deleteModal">Hapus</button>';
            })
            ->make(true);
    }

    // Kembalikan view
    return view('admin.dataTiket.index');
    }

    /* Delete Tiket */
    public function deleteTiket(Request $request) {
        $queue = DataQueuing::findOrFail($request->id);
        $queue->delete();

        return redirect()->route('datatiketcustomer')->with('success', 'Data tiket berhasil dihapus.');
    }

   /* Data Antrian */
    /* Menampilkan Data Antrian */
    public function index(Request $request) {
        if ($request->ajax()) {
            $id = $request->input('jenis_antrian'); // Dapatkan jenis antrian dari request

            // Menampilkan data antrian berdasarkan jenis_antrian yang dipilih
            $queues = DataQueuing::with('user')
                ->where('jenis_antrian', $id) // Filter berdasarkan jenis_antrian
                ->orderBy('created_at', 'asc'); // Urutkan berdasarkan waktu pembuatan

            return DataTables::of($queues)
                ->addIndexColumn() // Menambahkan kolom index untuk nomor urut
                ->addColumn('action', function($queue){
                    return '
                        <button type="button" class="btn btn-success btn-sm call-button" data-id="'.$queue->id.'">Panggil</button>
                        <button type="button" class="btn btn-warning btn-sm complete-button" data-id="'.$queue->id.'">Selesai</button>
                        <a href="'.route('generatepdfantrian', $queue->id).'" class="btn btn-info btn-sm">PDF</a>
                    ';
                })
                ->editColumn('status', function($queue) {
                    return $queue->status === 'called' ? 'Selesai' : 'Menunggu';
                })
                ->make(true);
        }

        return view('admin.dataAntrian.index');
    }

    /* Generate PDF */
    public function generatePDF($id) {
        $queue = DataQueuing::with('user')->findOrFail($id);
        
        // Cari semua antrian dengan jenis yang sama dan urutkan berdasarkan created_at
        $antrian_sejenis = DataQueuing::where('jenis_antrian', $queue->jenis_antrian)
                                    ->orderBy('created_at', 'asc')
                                    ->get();

        // Cari posisi nomor urut dari antrian yang dipilih
        $nomor_urut = $antrian_sejenis->search(function($item) use ($queue) {
            return $item->id === $queue->id;
        }) + 1; // Ditambah 1 karena index dimulai dari 0

        $pdf = PDF::loadView('admin.dataAntrian.reportAntrian', compact('queue', 'nomor_urut'))
                ->setPaper([0, 0, 200, 400]); // Atur ukuran kertas kecil

        return $pdf->download('Tiket_Antrian_'.$queue->id.'.pdf');
    }


    /* Tandai sebagai selesai */
    public function completeAntrian(Request $request) {
        $queue = DataQueuing::findOrFail($request->id);
        $queue->status = 'called';
        $queue->save();

        return response()->json(['success' => 'Antrian telah ditandai selesai']);
    }

    /* Hapus Antrian */
    public function deleteAntrian(Request $request) {
        $queue = DataQueuing::findOrFail($request->id);
        $queue->delete();

        return redirect()->route('dataantrianAdmine')->with('success', 'Data antrian berhasil dihapus.');
    }

}
