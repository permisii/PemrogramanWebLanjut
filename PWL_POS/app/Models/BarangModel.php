<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangModel extends Model {
    use HasFactory;

    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';


}
