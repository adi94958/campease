<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'data_transaksi';
    protected $fillable = [
        'id_transaksi',
        'nama_penyewa',
        'no_handphone',
        'tanggal_check_in',
        'tanggal_check_out',
        'area_kavling'
    ];

    // Definisikan relasi dengan model Kavling
    public function kavling()
    {
        return $this->belongsTo(Kavling::class, 'area_kavling', 'area_kavling');
    }
}
