<?php

namespace App\Http\Controllers;

use App\Models\MétodoPago;
use Illuminate\Http\Request;

class MétodoPagoController extends Controller
{
    public function index()
    {
        $metodospago = MétodoPago::all();
        return view('métodospago.index', compact('metodospago'));
    }

    public function create()
    {
        return view('metodospago.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:metodospago',
        ]);

        MétodoPago::create($request->all());
        return redirect()->route('métodospago.index');
    }

    public function edit(MétodoPago $métodoPago)
    {
        return view('metodospago.edit', compact('métodoPago'));
    }

    public function update(Request $request, MétodoPago $métodoPago)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $métodoPago->update($request->all());
        return redirect()->route('metodospago.index');
    }

    public function destroy(MétodoPago $métodoPago)
    {
        $métodoPago->delete();
        return redirect()->route('metodospago.index');
    }
}
