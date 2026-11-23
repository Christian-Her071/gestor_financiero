@extends('layouts.gestor')

@section('title', 'Editar cuenta')
@section('page_title', 'Editar cuenta')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('cuentas.update', $cuenta) }}" method="POST">
            @method('PUT')
            @include('cuentas._form')
        </form>
    </div>
</div>
@endsection