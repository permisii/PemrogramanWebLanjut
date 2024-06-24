<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenjualanModel extends Model
{
    use HasFactory;
    
    protected $table = 't_penjualan';
    public $timestamps = true;
    protected $primaryKey = 'penjualan_id';

    protected $fillable =  [
        'user_id', 
        'pembeli', 
        'penjualan_kode', 
        'penjualan_tanggal', 
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(userModel::class, 'user_id', 'user_id');
    }



    protected $casts = [
        'penjualan_tanggal'  => 'date:d-m-Y',
    ];
}
