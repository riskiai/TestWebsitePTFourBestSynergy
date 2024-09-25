@extends('app.master')

@section('style')
    <style>
        .dashboard-container {
            margin-top: 50px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f8b400;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
        }

        .table th, .table td {
            vertical-align: middle;
        }
        
        .table thead th {
            background-color: #f8b400;
            color: white;
        }
    </style>
@endsection

@section('content')
<div class="container dashboard-container">
    <div class="row">
        <!-- Data Antrian -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    Data Antrian Dan Data Customer
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Polisi</th>
                                <th>Jenis Antrian</th>
                                <th>Status</th>
                                <th>Nama Pengguna</th>
                                <th>Alamat</th>
                                <th>Nomor HP</th>
                                <th>Tanggal Antrian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($queues as $index => $queue)
                                <tr>
                                    <td>{{ $index + 1 + ($queues->currentPage() - 1) * $queues->perPage() }}</td>
                                    <td>{{ $queue->no_polisi }}</td>
                                    <td>{{ $queue->jenis_antrian }}</td>
                                    <td>{{ ucfirst($queue->status) }}</td>
                                    <td>{{ $queue->user ? $queue->user->name : 'Pengguna tidak ditemukan' }}</td>
                                    <td>{{ $queue->user ? $queue->user->address : 'Alamat tidak tersedia' }}</td>
                                    <td>{{ $queue->user ? $queue->user->phone_number : 'Nomor HP tidak tersedia' }}</td>
                                    <td>{{ $queue->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Tambahkan pagination di bawah tabel -->
                    <div class="d-flex justify-content-center">
                        {{ $queues->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
