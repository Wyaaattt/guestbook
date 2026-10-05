<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departemens';
    // nama table 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nama', 'deskripsi', 'lokasi'];
    // kolom 
    public function kunjungan()
    {
        return $this->hasMany(Kunjungan::class, 'id_departemen', 'id');
    }
    //membuat relasi antara kunjungan dan departemen
}

