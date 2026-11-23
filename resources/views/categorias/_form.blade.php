@csrf

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" id="nombre" name="nombre" maxlength="150" required
           class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $categoria->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label for="tipo" class="form-label">Tipo</label>
    <select id="tipo" name="tipo" required class="form-select @error('tipo') is-invalid @enderror">
        <option value="">-- Seleccione --</option>
        <option value="ingreso" {{ old('tipo', $categoria->tipo ?? '') == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
        <option value="gasto" {{ old('tipo', $categoria->tipo ?? '') == 'gasto' ? 'selected' : '' }}>Gasto</option>
    </select>
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label">Descripción (opcional)</label>
    <input type="text" id="descripcion" name="descripcion" maxlength="255"
           class="form-control @error('descripcion') is-invalid @enderror"
           value="{{ old('descripcion', $categoria->descripcion ?? '') }}">
</div>

<button type="submit" class="btn btn-primary">Guardar</button>
<a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>