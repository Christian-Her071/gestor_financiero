@extends('layouts.gestor')

@section('title', 'Nueva categoría')
@section('page_title', 'Nueva categoría')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('categorias.store') }}" method="POST">
            @include('categorias._form')
        </form>
    </div>
</div>
@endsection