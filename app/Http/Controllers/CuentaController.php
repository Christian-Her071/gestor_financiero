<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use Illuminate\Http\Request;

class CuentaController extends Controller
{
    public function index()
    {
        $cuentas = Cuenta::orderBy('nombre')->get();
        return view('cuentas.index', compact('cuentas'));
    }

    public function create()
    {
        return view('cuentas.create');
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);
        Cuenta::create($datos);

        return redirect()->route('cuentas.index')
            ->with('success', 'Cuenta creada correctamente.');
    }

    public function edit(Cuenta $cuenta)
    {
        return view('cuentas.edit', compact('cuenta'));
    }

    public function update(Request $request, Cuenta $cuenta)
    {
        $datos = $this->validar($request);
        $cuenta->update($datos);

        return redirect()->route('cuentas.index')
            ->with('success', 'Cuenta actualizada correctamente.');
    }

    public function destroy(Cuenta $cuenta)
    {
        
        if ($cuenta->transacciones()->exists()) {
            return redirect()->route('cuentas.index')
                ->with('error', 'No se puede eliminar la cuenta "' . $cuenta->nombre . '" porque tiene transacciones asociadas.');
        }

        $cuenta->delete();

        return redirect()->route('cuentas.index')
            ->with('success', 'Cuenta eliminada correctamente.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'nombre'      => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:255',
            'saldo'       => 'required|numeric|min:0',
            'moneda'      => 'required|string|max:10',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar 150 caracteres.',
            'descripcion.max' => 'La descripción no puede superar 255 caracteres.',
            'saldo.required'  => 'El saldo es obligatorio.',
            'saldo.numeric'   => 'El saldo debe ser un número.',
            'saldo.min'       => 'El saldo no puede ser negativo.',
            'moneda.required' => 'La moneda es obligatoria.',
            'moneda.max'      => 'La moneda no puede superar 10 caracteres.',
        ]);
    }
}