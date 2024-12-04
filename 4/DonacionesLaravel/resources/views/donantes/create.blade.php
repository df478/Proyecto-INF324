{{-- resources/views/donantes/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-center">Nuevo Donante</h1>

    <form action="{{ route('donantes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>

        <div class="mb-3">
            <label for="teléfono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="teléfono" name="teléfono" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Guardar Donante</button>
            <a href="{{ route('donantes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
@endsection
