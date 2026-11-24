@csrf

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="cuenta_id" class="form-label">Cuenta</label>
        <select id="cuenta_id" name="cuenta_id" required class="form-select @error('cuenta_id') is-invalid @enderror">
            <option value="">-- Seleccione --</option>
            @foreach ($cuentas as $cuenta)
                <option value="{{ $cuenta->id }}"
                    {{ old('cuenta_id', $transaccion->cuenta_id ?? '') == $cuenta->id ? 'selected' : '' }}>
                    {{ $cuenta->nombre }} (saldo: ${{ number_format($cuenta->saldo, 2, ',', '.') }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="tipo" class="form-label">Tipo de movimiento</label>
        <select id="tipo" name="tipo" required class="form-select @error('tipo') is-invalid @enderror">
            <option value="">-- Seleccione --</option>
            <option value="ingreso" {{ old('tipo', $transaccion->tipo ?? '') == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
            <option value="gasto" {{ old('tipo', $transaccion->tipo ?? '') == 'gasto' ? 'selected' : '' }}>Gasto</option>
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="categoria_id" class="form-label">Categoría</label>
        <select id="categoria_id" name="categoria_id" required class="form-select @error('categoria_id') is-invalid @enderror">
            <option value="">-- Seleccione --</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}"
                    {{ old('categoria_id', $transaccion->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombre }} ({{ ucfirst($categoria->tipo) }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="monto" class="form-label">Monto</label>
        <input type="number" id="monto" name="monto" step="0.01" min="0.01" required
               class="form-control @error('monto') is-invalid @enderror"
               value="{{ old('monto', $transaccion->monto ?? '') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date" id="fecha" name="fecha" required
               class="form-control @error('fecha') is-invalid @enderror"
               value="{{ old('fecha', isset($transaccion) ? $transaccion->fecha->format('Y-m-d') : date('Y-m-d')) }}">
    </div>

    <div class="col-md-6 mb-3">
        <label for="descripcion" class="form-label">Descripción (opcional)</label>
        <input type="text" id="descripcion" name="descripcion" maxlength="255"
               class="form-control @error('descripcion') is-invalid @enderror"
               value="{{ old('descripcion', $transaccion->descripcion ?? '') }}">
    </div>
</div>

<button type="submit" class="btn btn-primary">Guardar</button>
<a href="{{ route('transacciones.index') }}" class="btn btn-secondary">Cancelar</a>