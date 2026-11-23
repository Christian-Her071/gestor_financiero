<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = 'transacciones';

    protected $fillable = [
        'cuenta_id', 'categoria_id', 'tipo', 'monto',
        'fecha', 'descripcion', 'creado_por',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha' => 'date',
    ];

    // Una transacción pertenece a una cuenta
    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_id');
    }

    // Una transacción pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}