@extends('app.master')

@section('style')
    <style>
        .form-container {
            margin-top: 50px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
            font-size: 24px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-submit {
            background-color: #f8b400;
            color: white;
            font-weight: bold;
        }
        .btn-submit:hover {
            background-color: #ffcc00;
        }
    </style>
@endsection

@section('content')
<div class="form-container">
    <h2 class="form-title">Ambil Tiket Antrian</h2>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @if(session('queue_id'))
            <a href="{{ route('printTicket', session('queue_id')) }}" class="btn btn-primary">Cetak Tiket</a>
        @endif
    @elseif (session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif
    
    <form method="POST" action="{{ route('formTiketProsess') }}">
        @csrf
        
        <!-- Nomor Polisi -->
        <div class="mb-3">
            <label for="no_polisi" class="form-label">Nomor Polisi</label>
            <input type="text" name="no_polisi" id="no_polisi" class="form-control" placeholder="Masukkan Nomor Polisi" value="{{ old('no_polisi') }}" required>
        </div>

        <!-- Pilihan Jenis Antrian -->
        <div class="mb-3">
            <label for="jenis_antrian" class="form-label">Pilih Jenis Antrian</label>
            <select class="form-select" name="jenis_antrian" id="jenis_antrian" required>
                <option value="">Pilih Jenis Antrian</option>
                <option value="GR" {{ old('jenis_antrian') == 'GR' ? 'selected' : '' }}>GR</option>
                <option value="BP" {{ old('jenis_antrian') == 'BP' ? 'selected' : '' }}>BP</option>
            </select>
        </div>

        <!-- Jika data pelanggan belum ada, form ini akan muncul -->
        <div id="additional-info" style="display:none;">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan Nama" value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Alamat</label>
                <input type="text" name="address" id="address" class="form-control" placeholder="Masukkan Alamat" value="{{ old('address') }}">
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Nomor HP</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Masukkan Nomor HP" value="{{ old('phone_number') }}">
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-submit w-100">Ambil Tiket</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
  document.getElementById('no_polisi').addEventListener('blur', function() {
    var noPolisi = this.value.trim();

    if (noPolisi !== '') {
        // Melakukan pengecekan nomor polisi melalui route checkNoPolisi
        fetch('{{ route("checkNoPolisi") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ no_polisi: noPolisi })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                // Jika data ada, sembunyikan form tambahan dan isi dengan data yang ada
                document.getElementById('additional-info').style.display = 'none';
                document.getElementById('name').value = data.name;
                document.getElementById('address').value = data.address;
                document.getElementById('phone_number').value = data.phone_number;
                alert('Nomor Polisi sudah terdaftar. Data pendaftar otomatis diisi.');
            } else {
                // Jika data tidak ada, tampilkan form tambahan
                document.getElementById('additional-info').style.display = 'block';
                document.getElementById('name').value = '';
                document.getElementById('address').value = '';
                document.getElementById('phone_number').value = '';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});
</script>
@endsection

