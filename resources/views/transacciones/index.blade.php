@extends('layouts.gestor')

@section('title', 'Transacciones')
@section('page_title', 'Transacciones')

@section('content')
<a href="{{ route('transacciones.create') }}" class="btn btn-primary mb-3">Nueva transacción</a>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Fecha</th><th>Cuenta</th><th>Categoría</th><th>Tipo</th>
                    <th class="text-end">Monto</th><th>Descripción</th><th>Registrado por</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transacciones as $t)
                    <tr>
                        <td>{{ $t->fecha->format('d/m/Y') }}</td>
                        <td>{{ $t->cuenta->nombre }}</td>
                        <td>{{ $t->categoria->nombre }}</td>
                        <td>
                            <span class="badge {{ $t->tipo == 'ingreso' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($t->tipo) }}
                            </span>
                        </td>
                        <td class="text-end {{ $t->tipo == 'ingreso' ? 'text-success' : 'text-danger' }}">
                            {{ $t->tipo == 'ingreso' ? '+' : '-' }}${{ number_format($t->monto, 2, ',', '.') }}
                        </td>
                        <td>{{ $t->descripcion }}</td>
                        <td>{{ $t->creado_por }}</td>
                        <td class="text-end">
                            <a href="{{ route('transacciones.edit', $t) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('transacciones.destroy', $t) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta transacción? Se revertirá el saldo.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-muted">No hay transacciones registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection