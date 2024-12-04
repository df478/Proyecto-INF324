{{-- resources/views/donaciones/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-center">Nueva Donación</h1>

    <form action="{{ route('donaciones.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="donante_id" class="form-label">Donante</label>
            <select class="form-control" id="donante_id" name="donante_id" required>
                <option value="" disabled selected>Seleccione un Donante</option>
                @foreach ($donantes as $donante)
                    <option value="{{ $donante->id }}">{{ $donante->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="campaña_id" class="form-label">Campaña</label>
            <select class="form-control" id="campaña_id" name="campaña_id" required>
                <option value="" disabled selected>Seleccione una Campaña</option>
                @foreach ($campañas as $campaña)
                    <option value="{{ $campaña->id }}">{{ $campaña->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="método_pago_id" class="form-label">Método de Pago</label> {{-- Campo para el método de pago --}}
            <select class="form-control" id="método_pago_id" name="método_pago_id" required>
                <option value="" disabled selected>Seleccione un Método de Pago</option>
                @foreach ($metodosPago as $metodoPago)
                    <option value="{{ $metodoPago->id }}">{{ $metodoPago->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="monto" class="form-label">Monto</label>
            <input type="number" class="form-control" id="monto" name="monto" required>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Guardar Donación</button>
            <a href="{{ route('donaciones.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
@endsection
