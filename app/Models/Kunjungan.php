<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kunjungans';
    // nama table
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_tamu', 'id_departemen', 'tujuan', 'bertemu_dengan', 'waktu_masuk', 'waktu_keluar', 'status'];
    //kolom

    // relasi antara tamu dan departemen
    public function tamu()
    {
        return $this->belongsTo(Tamu::class, 'id_tamu');
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class,'id_departemen');
    }
}
