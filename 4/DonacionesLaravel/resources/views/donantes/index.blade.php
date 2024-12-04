{{-- resources/views/donantes/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-center">Lista de Donantes</h1>

    <div class="mb-3">
        <a href="{{ route('donantes.create') }}" class="btn btn-primary">Agregar Donante</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donantes as $donante)
                    <tr>
                        <td>{{ $donante->id }}</td>
                        <td>{{ $donante->nombre }}</td>
                        <td>{{ $donante->correo }}</td>
                        <td>{{ $donante->teléfono }}</td>
                        <td>
                            <a href="{{ route('donantes.edit', $donante->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('donantes.destroy', $donante->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este donante?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
