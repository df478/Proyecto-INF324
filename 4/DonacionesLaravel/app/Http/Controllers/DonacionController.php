<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Donacion;
use App\Models\Donante;
use App\Models\Campaña;
use App\Models\MétodoPago;
use Illuminate\Http\Request;

class DonacionController extends Controller
{
    public function index()
    {
        $donaciones = Donacion::all(); // O cualquier lógica para obtener las donaciones
        $donantes = Donante::all(); // Obtén todos los donantes
        $campañas = Campaña::all(); // Obtén todas las campañas

        return view('donaciones.index', compact('donaciones', 'donantes', 'campañas'));
    }

    public function create()
    {
        $donantes = Donante::all();
        $campañas = Campaña::all();
        $metodosPago = MétodoPago::all();
        return view('donaciones.create', compact('donantes', 'campañas', 'metodosPago'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'donante_id' => 'required',
            'campaña_id' => 'required',
            'método_pago_id' => 'required',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
        ]);

        Donacion::create($request->all());
        return redirect()->route('donaciones.index');
    }

    public function edit($id)
    {
        // Buscar la fila en la tabla 'donaciones' utilizando el identificador (id)
        $donacion = Donacion::find($id);
        $donantes = Donante::all();
        $campanas = Campaña::all();
        $metodosPago = MétodoPago::all();
        // Verificar si la donación existe
        if (!$donacion) {
            // Si no se encuentra la donación, podrías redirigir o mostrar un mensaje de error
            return redirect()->route('donaciones.index')->with('error', 'Donación no encontrada');
        }

        // Pasar la donación a la vista
        return view('donaciones.edit', compact('donacion','donantes','campanas','metodosPago'));
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'donante_id' => 'required',
            'campania_id' => 'required',
            'metodo_pago_id' => 'required',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
        ]);

        $affected = DB::update('UPDATE donaciones SET donante_id = ?, campaña_id = ?, método_pago_id = ?, monto = ?, fecha = ? WHERE id = ?',
                            [
                                $request->donante_id,
                                $request->campania_id,
                                $request->metodo_pago_id,
                                $request->monto,
                                $request->fecha,
                                $id
                            ]);

        return redirect()->route('donaciones.index');
    }

    public function destroy($id)
    {
        $donacion = Donacion::find($id);
        $donacion->delete();
        return redirect()->route('donaciones.index');
    }
}
