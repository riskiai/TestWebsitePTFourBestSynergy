@extends('app.master')

@section('style')
    <style>
        .table-container {
            margin-top: 50px;
        }

        .table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .table-striped tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-striped tr:hover {
            background-color: #ddd;
        }

        .btn-tambah {
            margin-bottom: 20px;
            background-color: #f8b400; 
            color: white;
        }

        .btn-tambah:hover {
            background-color: #e69500; 
        }
    </style>
    <!-- Tambahkan DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="container table-container">
    <h2 class="text-right">Daftar Antrian</h2>

    <!-- Tambahkan Dropdown Filter Jenis Antrian -->
    <div class="form-group">
        <label for="jenisAntrianSelect">Jenis Antrian</label>
        <select id="jenisAntrianSelect" class="form-control">
            <option value="">Semua Jenis</option>
            <option value="GR">GR</option>
            <option value="BP">BP</option>
        </select>
    </div>

    <table id="queuesTable" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>No Polisi</th>
                <th>Jenis Antrian</th>
                <th>Status</th>
                <th>Nama Pengguna</th>
                <th>Alamat</th>
                <th>Nomor HP</th>
                <th>Tanggal Pengambilan</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal untuk konfirmasi hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteForm" method="POST" action="{{ route('deleteantrian') }}">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus antrian ini?
                    <input type="hidden" name="id" id="deleteId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <!-- Tambahkan DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables dengan server-side processing
            var table = $('#queuesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('dataantrianAdmine') }}",
                    data: function (d) {
                        d.jenis_antrian = $('#jenisAntrianSelect').val(); // Ambil nilai jenis antrian dari select input
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, // Make sure it's not orderable or searchable
                    { data: 'no_polisi', name: 'no_polisi' },
                    { data: 'jenis_antrian', name: 'jenis_antrian' },
                    { data: 'status', name: 'status' },
                    { data: 'user.name', name: 'user.name' },
                    { data: 'user.address', name: 'user.address' },
                    { data: 'user.phone_number', name: 'user.phone_number' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                order: [[7, 'asc']] // Sort by created_at column, adjust index as needed
            });

            // Filter data berdasarkan jenis antrian ketika jenis antrian berubah
            $('#jenisAntrianSelect').on('change', function () {
                table.ajax.reload();
            });

            // Panggil nomor antrian
            $(document).on('click', '.call-button', function() {
                alert('Memanggil nomor antrian ' + $(this).data('id'));
            });

            // Tandai sebagai selesai
            $(document).on('click', '.complete-button', function() {
                var id = $(this).data('id');
                $.post("{{ route('completeantrian') }}", {
                    _token: '{{ csrf_token() }}',
                    id: id
                }, function(data) {
                    alert(data.success);
                    $('#queuesTable').DataTable().ajax.reload();
                });
            });

            // Mendapatkan data untuk modal hapus
            $(document).on('click', '.delete-button', function() {
                var id = $(this).data('id');
                $('#deleteId').val(id);
            });
        });
    </script>
@endsection
