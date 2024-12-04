<?php

namespace App\Http\Controllers;

use App\Models\Donante;
use Illuminate\Http\Request;

class DonanteController extends Controller
{
    public function index()
    {
        $donantes = Donante::all();
        return view('donantes.index', compact('donantes'));
    }

    public function create()
    {
        return view('donantes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email|unique:donantes',
        ]);

        Donante::create($request->all());
        return redirect()->route('donantes.index');
    }

    public function edit(Donante $donante)
    {
        return view('donantes.edit', compact('donante'));
    }

    public function update(Request $request, Donante $donante)
    {
        $request->validate([
            'nombre' => 'required',
            'correo' => 'required|email',
        ]);

        $donante->update($request->all());
        return redirect()->route('donantes.index');
    }

    public function destroy(Donante $donante)
    {
        $donante->delete();
        return redirect()->route('donantes.index');
    }
}

