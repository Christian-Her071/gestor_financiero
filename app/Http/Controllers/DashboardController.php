<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Transaccion;

class DashboardController extends Controller
{
    public function index()
    {
        $cuentas = Cuenta::orderBy('nombre')->get();
        $totalIngresos = Transaccion::where('tipo', 'ingreso')->sum('monto');
        $totalGastos = Transaccion::where('tipo', 'gasto')->sum('monto');
        $ultimas = Transaccion::with(['cuenta', 'categoria'])
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('dashboard', compact('cuentas', 'totalIngresos', 'totalGastos', 'ultimas'));
    }
}