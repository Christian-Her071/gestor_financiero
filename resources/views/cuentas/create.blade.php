@extends('layouts.gestor')

@section('title', 'Nueva cuenta')
@section('page_title', 'Nueva cuenta')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('cuentas.store') }}" method="POST">
            @include('cuentas._form')
        </form>
    </div>
</div>
@endsection