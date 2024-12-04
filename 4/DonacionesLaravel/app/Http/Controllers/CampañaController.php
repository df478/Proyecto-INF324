<?php

namespace App\Http\Controllers;

use App\Models\Campaña;
use Illuminate\Http\Request;

class CampañaController extends Controller
{
    public function index()
    {
        $campañas = Campaña::all();
        return view('campañas.index', compact('campañas'));
    }

    public function create()
    {
        return view('campañas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'meta_recaudación' => 'required|numeric',
        ]);

        Campaña::create($request->all());
        return redirect()->route('campañas.index');
    }

    public function edit(Campaña $campaña)
    {
        return view('campañas.edit', compact('campaña'));
    }

    public function update(Request $request, Campaña $campaña)
    {
        $request->validate([
            'nombre' => 'required',
            'meta_recaudación' => 'required|numeric',
        ]);

        $campaña->update($request->all());
        return redirect()->route('campañas.index');
    }

    public function destroy(Campaña $campaña)
    {
        $campaña->delete();
        return redirect()->route('campañas.index');
    }
}
