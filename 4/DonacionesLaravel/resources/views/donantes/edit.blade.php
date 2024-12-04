{{-- resources/views/donantes/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-center">Editar Donante</h1>

    <form action="{{ route('donantes.update', $donante->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $donante->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo</label>
            <input type="email" class="form-control" id="correo" name="correo" value="{{ $donante->correo }}" required>
        </div>

        <div class="mb-3">
            <label for="teléfono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="teléfono" name="teléfono" value="{{ $donante->teléfono }}" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Actualizar Donante</button>
            <a href="{{ route('donantes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
@endsection
