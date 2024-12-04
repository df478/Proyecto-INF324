{{-- resources/views/donaciones/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-center">Editar Donación</h1>

    <form action="{{ route('donaciones.update', $donacion->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="donante_id" class="form-label">Donante</label>
            <select class="form-control" id="donante_id" name="donante_id" required>
                <option value="" disabled>Seleccione un Donante</option>
                @foreach ($donantes as $donante)
                    <option value="{{ $donante->id }}" {{ $donacion->donante_id == $donante->id ? 'selected' : '' }}>
                        {{ $donante->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="campania_id" class="form-label">Campaña</label>
            <select class="form-control" id="campania_id" name="campania_id" required>
                <option value="" disabled>Seleccione una Campaña</option>
                @foreach ($campanas as $campana)
                    <option value="{{ $campana->id }}" {{ $donacion->campania_id == $campana->id ? 'selected' : '' }}>
                        {{ $campana->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="metodo_pago_id" class="form-label">Método de Pago</label> {{-- Campo para el método de pago --}}
            <select class="form-control" id="metodo_pago_id" name="metodo_pago_id" required>
                <option value="" disabled>Seleccione un Método de Pago</option>
                @foreach ($metodosPago as $metodoPago)
                    <option value="{{ $metodoPago->id }}" {{ $donacion->metodo_pago_id == $metodoPago->id ? 'selected' : '' }}>
                        {{ $metodoPago->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="monto" class="form-label">Monto</label>
            <input type="number" class="form-control" id="monto" name="monto" value="{{ $donacion->monto }}" required>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $donacion->fecha }}" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Actualizar Donación</button>
            <a href="{{ route('donaciones.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
@endsection
