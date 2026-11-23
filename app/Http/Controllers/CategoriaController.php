<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::orderBy('tipo')->orderBy('nombre')->get();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);
        Categoria::create($datos);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $datos = $this->validar($request);

        if ($categoria->tipo !== $datos['tipo'] && $categoria->transacciones()->exists()) {
            return back()->withInput()
                ->with('error', 'No se puede cambiar el tipo de una categoría que ya tiene transacciones.');
        }

        $categoria->update($datos);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        // Regla del taller: no eliminar categorías con transacciones asociadas
        if ($categoria->transacciones()->exists()) {
            return redirect()->route('categorias.index')
                ->with('error', 'No se puede eliminar la categoría "' . $categoria->nombre . '" porque tiene transacciones asociadas.');
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'nombre'      => 'required|string|max:150',
            'tipo'        => 'required|in:ingreso,gasto',
            'descripcion' => 'nullable|string|max:255',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max'      => 'El nombre no puede superar 150 caracteres.',
            'tipo.required'   => 'Debe seleccionar el tipo (ingreso o gasto).',
            'tipo.in'         => 'El tipo debe ser ingreso o gasto.',
            'descripcion.max' => 'La descripción no puede superar 255 caracteres.',
        ]);
    }
}