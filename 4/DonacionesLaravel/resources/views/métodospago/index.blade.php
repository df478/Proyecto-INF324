{{-- resources/views/metodos_pago/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-center">Métodos de Pago</h1>


    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Método de Pago</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($metodospago as $metodoPago)
                    <tr>
                        <td>{{ $metodoPago->id }}</td>
                        <td>{{ $metodoPago->nombre }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
