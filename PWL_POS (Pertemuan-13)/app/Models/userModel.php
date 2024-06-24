<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class userModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';
    public $timestamps = true;
    protected $primaryKey = 'user_id';

    protected $fillable =  [
        'user_id',
        'level_id',
        'username',
        'nama',
        'alamat',
        'no_ktp',
        'no_telp',
        'password',
        'profile_img',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public function hasLevel($level)
    {
        if ($level == $this->level->level_nama) {
            return true;
        }

        return false;
    }
}
