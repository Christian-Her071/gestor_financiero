@extends('layouts.gestor')

@section('title', 'Editar transacción')
@section('page_title', 'Editar transacción')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('transacciones.update', $transaccion) }}" method="POST">
            @method('PUT')
            @include('transacciones._form')
        </form>
    </div>
</div>
@endsection