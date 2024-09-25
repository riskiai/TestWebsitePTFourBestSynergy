<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Antrian</title>
    <style>
        .ticket-container {
            width: 100%;
            max-width: 250px; /* Lebar lebih kecil */
            margin: 0 auto; /* Tengah */
            padding: 5px; /* Sedikit padding */
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: 'Poppins', sans-serif;
            background-color: #fff; /* Warna latar putih */
        }

        .ticket-header {
            font-size: 20px; /* Ukuran font lebih kecil */
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .ticket-info {
            font-size: 16px; /* Sedikit lebih kecil */
            margin-bottom: 15px; /* Jarak antar bagian */
            color: #555;
        }

        .ticket-id {
            font-size: 28px; /* Ukuran font lebih kecil agar pas */
            font-weight: bold;
            color: #f8b400;
        }

        .ticket-footer {
            font-size: 12px;
            color: #888;
            margin-top: 15px;
        }

        .divider {
            width: 100%;
            height: 1px;
            background-color: #ddd;
            margin: 15px 0;
        }

        /* Untuk tampilan cetak */
        @media print {
            body {
                visibility: hidden;
            }

            .ticket-container {
                visibility: visible;
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

<div class="ticket-container">
    <div class="ticket-header">
        Tiket Antrian
    </div>
    <div class="divider"></div>
    <div class="ticket-info">
        Nama: {{ $queue->user->name }}<br>
        No. Polisi: {{ $queue->no_polisi }}<br>
        Jenis Antrian: {{ $queue->jenis_antrian }}<br>
    </div>
    <div class="ticket-id">
        No Antrian: {{ session('queue_number') }} <!-- Nomor urut berdasarkan jenis antrian -->
    </div>
    <div class="divider"></div>
    <div class="ticket-footer">
        Terima kasih telah mengambil antrian!<br>
        {{ now()->format('d M Y, H:i') }}
    </div>
</div>

</body>
</html>
