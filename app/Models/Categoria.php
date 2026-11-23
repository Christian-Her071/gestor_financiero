<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = ['nombre', 'tipo', 'descripcion'];

    // Una categoría tiene muchas transacciones
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'categoria_id');
    }
}