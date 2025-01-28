<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Paise extends Model
{
    protected $table = 'paises'; // Define table name
    use HasFactory;

    protected $fillable = [
        'nombre', 'cod', 'moneda', 'activo', 'borrado', 'fecha'
    ];

    public function provincias()
    {
        return $this->hasMany(Provincia::class, 'fk_pais', 'id'); // Relation to provinces
    }
}

