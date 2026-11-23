@extends('layouts.gestor')

@section('title', 'Editar categoría')
@section('page_title', 'Editar categoría')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('categorias.update', $categoria) }}" method="POST">
            @method('PUT')
            @include('categorias._form')
        </form>
    </div>
</div>
@endsection