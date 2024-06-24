<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StokModel extends Model
{
    use HasFactory;

    protected $table = 't_stok';
    public $timestamps = true;
    protected $primaryKey = 'stok_id';

    protected $fillable =  [
        'barang_id', 
        'user_id', 
        'stok_tanggal', 
        'stok_jumlah', 
    ];


    public function barang(): BelongsTo
    {
        return $this->belongsTo(BarangModel::class, 'barang_id', 'barang_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(userModel::class, 'user_id', 'user_id');
    }

    protected $casts = [
        'stok_tanggal'  => 'date:d-m-Y',
    ];
}
