@extends('app.master')

@section('style')
    <style>
        .antrian-container {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
        }
        .antrian-box {
            width: 200px;
            height: 150px;
            background-color: #f8b400;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
        }
        .antrian-box h2 {
            font-size: 36px;
            margin: 0;
        }
        .antrian-box p {
            font-size: 20px;
            margin: 0;
        }
        .info-text {
            text-align: center;
            margin-top: 20px;
            font-size: 20px;
            color: #333;
            font-weight: bold;
            font-family: sans-serif;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <!-- Informasi untuk pengguna -->
    <div class="info-text">
        Data Antrian sesuai jenis. Harap menunggu, antrian Anda akan segera dipanggil oleh admin.
    </div>

    <!-- Tampilkan data antrian GR dan BP -->
    <div class="antrian-container">
        <div class="antrian-box">
            <h2>{{ $countGR }}</h2> 
            <p>GR Antrian</p>
        </div>
        <div class="antrian-box">
            <h2>{{ $countBP }}</h2> 
            <p>BP Antrian</p>
        </div>
    </div>
</div>
@endsection
