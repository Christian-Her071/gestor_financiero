@extends('layouts.gestor')

@section('title', 'Categorías')
@section('page_title', 'Categorías')

@section('content')
<a href="{{ route('categorias.create') }}" class="btn btn-primary mb-3">Nueva categoría</a>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Nombre</th><th>Tipo</th><th>Descripción</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse ($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->nombre }}</td>
                        <td>
                            <span class="badge {{ $categoria->tipo == 'ingreso' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($categoria->tipo) }}
                            </span>
                        </td>
                        <td>{{ $categoria->descripcion }}</td>
                        <td class="text-end">
                            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta categoría?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-muted">No hay categorías registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection