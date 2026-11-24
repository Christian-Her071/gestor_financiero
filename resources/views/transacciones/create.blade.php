@extends('layouts.gestor')

@section('title', 'Nueva transacción')
@section('page_title', 'Nueva transacción')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('transacciones.store') }}" method="POST">
            @include('transacciones._form')
        </form>
    </div>
</div>
@endsection