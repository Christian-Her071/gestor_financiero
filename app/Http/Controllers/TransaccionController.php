<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Transaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransaccionController extends Controller
{
    public function index()
    {
        $transacciones = Transaccion::with(['cuenta', 'categoria'])
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->get();

        return view('transacciones.index', compact('transacciones'));
    }

    public function create()
    {
        return view('transacciones.create', [
            'cuentas'    => Cuenta::orderBy('nombre')->get(),
            'categorias' => Categoria::orderBy('tipo')->orderBy('nombre')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);

        DB::transaction(function () use ($datos) {
            $cuenta = Cuenta::lockForUpdate()->findOrFail($datos['cuenta_id']);

                
            $this->moverSaldo($cuenta, $datos['tipo'], $datos['monto'], false);
            $this->verificarSaldo($cuenta);

            Transaccion::create($datos + ['creado_por' => Auth::user()->name]);
        });

        return redirect()->route('transacciones.index')
            ->with('success', 'Transacción registrada y saldo actualizado.');
    }

    public function edit(Transaccion $transaccion)
    {
        return view('transacciones.edit', [
            'transaccion' => $transaccion,
            'cuentas'     => Cuenta::orderBy('nombre')->get(),
            'categorias'  => Categoria::orderBy('tipo')->orderBy('nombre')->get(),
        ]);
    }

    public function update(Request $request, Transaccion $transaccion)
    {
        $datos = $this->validar($request);

        DB::transaction(function () use ($datos, $transaccion) {
            $cuentaAnterior = Cuenta::lockForUpdate()->findOrFail($transaccion->cuenta_id);

            
            $cuentaNueva = ($datos['cuenta_id'] == $transaccion->cuenta_id)
                ? $cuentaAnterior
                : Cuenta::lockForUpdate()->findOrFail($datos['cuenta_id']);

           
            $this->moverSaldo($cuentaAnterior, $transaccion->tipo, $transaccion->monto, true);

           
            $this->moverSaldo($cuentaNueva, $datos['tipo'], $datos['monto'], false);

            
            $this->verificarSaldo($cuentaAnterior);
            if ($cuentaNueva->id != $cuentaAnterior->id) {
                $this->verificarSaldo($cuentaNueva);
            }

            $transaccion->update($datos);
        });

        return redirect()->route('transacciones.index')
            ->with('success', 'Transacción actualizada y saldos ajustados.');
    }

    public function destroy(Transaccion $transaccion)
    {
        try {
            DB::transaction(function () use ($transaccion) {
                $cuenta = Cuenta::lockForUpdate()->findOrFail($transaccion->cuenta_id);

                
                $this->moverSaldo($cuenta, $transaccion->tipo, $transaccion->monto, true);
                $this->verificarSaldo($cuenta);

                $transaccion->delete();
            });
        } catch (ValidationException $e) {
            return redirect()->route('transacciones.index')
                ->with('error', $e->validator->errors()->first());
        }

        return redirect()->route('transacciones.index')
            ->with('success', 'Transacción eliminada y saldo revertido.');
    }

    
    private function validar(Request $request): array
    {
        $datos = $request->validate([
            'cuenta_id'    => 'required|exists:cuentas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo'         => 'required|in:ingreso,gasto',
            'monto'        => 'required|numeric|gt:0|max:9999999999999',
            'fecha'        => 'required|date',
            'descripcion'  => 'nullable|string|max:255',
        ], [
            'cuenta_id.required'    => 'Debe seleccionar una cuenta.',
            'cuenta_id.exists'      => 'La cuenta seleccionada no existe.',
            'categoria_id.required' => 'Debe seleccionar una categoría.',
            'categoria_id.exists'   => 'La categoría seleccionada no existe.',
            'tipo.required'         => 'Debe seleccionar el tipo de movimiento.',
            'tipo.in'               => 'El tipo debe ser ingreso o gasto.',
            'monto.required'        => 'El monto es obligatorio.',
            'monto.numeric'         => 'El monto debe ser un número.',
            'monto.gt'              => 'El monto debe ser mayor que cero.',
            'monto.max'             => 'El monto es demasiado grande.',
            'fecha.required'        => 'La fecha es obligatoria.',
            'fecha.date'            => 'La fecha no es válida.',
            'descripcion.max'       => 'La descripción no puede superar 255 caracteres.',
        ]);

        
        $categoria = Categoria::findOrFail($datos['categoria_id']);
        if ($categoria->tipo !== $datos['tipo']) {
            throw ValidationException::withMessages([
                'categoria_id' => 'La categoría "' . $categoria->nombre . '" es de tipo ' . $categoria->tipo
                    . ' y no puede usarse en un movimiento de tipo ' . $datos['tipo'] . '.',
            ]);
        }

        return $datos;
    }

    
    private function moverSaldo(Cuenta $cuenta, string $tipo, $monto, bool $revertir): void
    {
        $suma = ($tipo === 'ingreso' && !$revertir) || ($tipo === 'gasto' && $revertir);

        if ($suma) {
            $cuenta->increment('saldo', $monto);
        } else {
            $cuenta->decrement('saldo', $monto);
        }
    }

   
    private function verificarSaldo(Cuenta $cuenta): void
    {
        $cuenta->refresh(); 

        if ((float) $cuenta->saldo < 0) {
            throw ValidationException::withMessages([
                'monto' => 'Saldo insuficiente: esta operación dejaría la cuenta "' . $cuenta->nombre
                    . '" con saldo negativo (' . number_format((float) $cuenta->saldo, 2, ',', '.') . ').',
            ]);
        }
    }
}