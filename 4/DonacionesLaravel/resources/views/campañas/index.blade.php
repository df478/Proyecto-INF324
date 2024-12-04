{{-- resources/views/campanas/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-center">Lista de Campañas</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Meta de Recaudación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($campañas as $campaña)
                    <tr>
                        <td>{{ $campaña->id }}</td>
                        <td>{{ $campaña->nombre }}</td>
                        <td>${{ number_format($campaña->meta_recaudación, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
