<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kavling extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'data_kavling';
    protected $fillable = [
        'area_kavling',
        'harga',
        'status'
    ];

    // Definisikan relasi dengan model Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'area_kavling', 'area_kavling');
    }
}
