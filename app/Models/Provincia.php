<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Provincia extends Model
{
    protected $table = 'provincias'; // Define table name
    use HasFactory;

    protected $fillable = [
        'fk_pais', 'nombre', 'cod', 'activo', 'borrado', 'fecha'
    ];

    public function pais()
    {
        return $this->belongsTo(Paise::class, 'fk_pais', 'id'); // Relation to country
    }
}

