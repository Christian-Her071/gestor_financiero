@csrf

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" id="nombre" name="nombre" maxlength="150" required
           class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $cuenta->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción (opcional)</label>
    <input type="text" id="descripcion" name="descripcion" maxlength="255"
           class="form-control @error('descripcion') is-invalid @enderror"
           value="{{ old('descripcion', $cuenta->descripcion ?? '') }}">
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="saldo" class="form-label">Saldo</label>
        <input type="number" id="saldo" name="saldo" step="0.01" min="0" required
               class="form-control @error('saldo') is-invalid @enderror"
               value="{{ old('saldo', $cuenta->saldo ?? '0.00') }}">
        <div class="form-text">El saldo cambia automáticamente con las transacciones.</div>
    </div>
    <div class="col-md-6 mb-3">
        <label for="moneda" class="form-label">Moneda</label>
        <input type="text" id="moneda" name="moneda" maxlength="10" required
               class="form-control @error('moneda') is-invalid @enderror"
               value="{{ old('moneda', $cuenta->moneda ?? 'COP') }}">
    </div>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>
<a href="{{ route('cuentas.index') }}" class="btn btn-secondary">Cancelar</a>