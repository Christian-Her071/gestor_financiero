@extends('layouts.gestor')

@section('title', 'Cuentas')
@section('page_title', 'Cuentas')

@section('content')
<a href="{{ route('cuentas.create') }}" class="btn btn-primary mb-3">Nueva cuenta</a>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr><th>Nombre</th><th>Descripción</th><th class="text-end">Saldo</th><th>Moneda</th><th class="text-end">Acciones</th></tr>
            </thead>
            <tbody>
                @forelse ($cuentas as $cuenta)
                    <tr>
                        <td>{{ $cuenta->nombre }}</td>
                        <td>{{ $cuenta->descripcion }}</td>
                        <td class="text-end"><strong>${{ number_format($cuenta->saldo, 2, ',', '.') }}</strong></td>
                        <td>{{ $cuenta->moneda }}</td>
                        <td class="text-end">
                            <a href="{{ route('cuentas.edit', $cuenta) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('cuentas.destroy', $cuenta) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta cuenta?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted">No hay cuentas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection