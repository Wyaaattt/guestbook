<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nama', 'instansi', 'telepon', 'email', 'alamat', 'foto', 'tanggal_daftar'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tamus';
    // nama table

    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class);
    }
    // membuat relasi dengan kunjungan 
}
