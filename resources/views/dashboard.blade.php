@extends('layouts.gestor')

@section('title', 'Inicio')
@section('page_title', 'Panel principal')

@section('content')
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card text-bg-primary h-100">
            <div class="card-body">
                <div>Saldo total</div>
                <div class="fs-3">${{ number_format($cuentas->sum('saldo'), 2, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-bg-success h-100">
            <div class="card-body">
                <div>Total ingresos registrados</div>
                <div class="fs-3">${{ number_format($totalIngresos, 2, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-bg-danger h-100">
            <div class="card-body">
                <div>Total gastos registrados</div>
                <div class="fs-3">${{ number_format($totalGastos, 2, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-5 mb-4">
        <div class="card">
            <div class="card-header">Saldo por cuenta</div>
            <ul class="list-group list-group-flush">
                @forelse ($cuentas as $cuenta)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $cuenta->nombre }}</span>
                        <strong>${{ number_format($cuenta->saldo, 2, ',', '.') }} {{ $cuenta->moneda }}</strong>
                    </li>
                @empty
                    <li class="list-group-item text-muted">Aún no hay cuentas.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="col-lg-7 mb-4">
        <div class="card">
            <div class="card-header">Últimas transacciones</div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr><th>Fecha</th><th>Cuenta</th><th>Categoría</th><th class="text-end">Monto</th></tr>
                    </thead>
                    <tbody>
                        @forelse ($ultimas as $t)
                            <tr>
                                <td>{{ $t->fecha->format('d/m/Y') }}</td>
                                <td>{{ $t->cuenta->nombre }}</td>
                                <td>{{ $t->categoria->nombre }}</td>
                                <td class="text-end {{ $t->tipo == 'ingreso' ? 'text-success' : 'text-danger' }}">
                                    {{ $t->tipo == 'ingreso' ? '+' : '-' }}${{ number_format($t->monto, 2, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-muted">Aún no hay transacciones.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection