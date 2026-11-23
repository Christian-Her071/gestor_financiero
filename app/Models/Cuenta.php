<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $table = 'cuentas';

    protected $fillable = ['nombre', 'descripcion', 'saldo', 'moneda'];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    // Una cuenta tiene muchas transacciones
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class, 'cuenta_id');
    }
}