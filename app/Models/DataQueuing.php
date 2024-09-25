<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataQueuing extends Model
{
    use HasFactory;

    protected $table = 'data_queuing'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'user_id',
        'no_polisi',
        'jenis_antrian',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
