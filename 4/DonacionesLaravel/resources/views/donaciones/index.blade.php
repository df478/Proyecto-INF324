{{-- resources/views/donaciones/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-center">Lista de Donaciones</h1>

    <div class="mb-3">
        <a href="{{ route('donaciones.create') }}" class="btn btn-primary">Agregar Donación</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Donante</th>
                    <th>Campaña</th>
                    <th>Método de Pago</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donaciones as $donacion)
                    <tr>
                        <td>{{ $donacion->id }}</td>
                        <td>{{ $donacion->donante->nombre }}</td>
                        <td>{{ $donacion->campaña->nombre }}</td>
                        <td>{{ $donacion->métodoPago->nombre }}</td>
                        <td>${{ number_format($donacion->monto, 2) }}</td>
                        <td>{{ $donacion->fecha }}</td>
                        <td>
                            <a href="{{ route('donaciones.edit', $donacion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('donaciones.destroy', $donacion->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta donación?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
