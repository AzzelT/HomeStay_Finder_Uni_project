<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::latest()->paginate(10);
        return view('admin.provinces.index', compact('provinces'));
    }

    public function create()
    {
        return view('admin.provinces.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:provinces,name'
        ]);

        Province::create(['name' => $request->name]);

        return redirect()->route('provinces.index')->with('success', 'Province added successfully!');
    }

    public function show(Province $province)
    {
        return view('admin.provinces.show', compact('province'));
    }

    public function edit(Province $province)
    {
        return view('admin.provinces.edit', compact('province'));
    }

    public function update(Request $request, Province $province)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:provinces,name,' . $province->id
        ]);

        $province->update(['name' => $request->name]);

        return redirect()->route('provinces.index')->with('success', 'Province updated successfully!');
    }

    public function destroy(Province $province)
    {
        $province->delete();
        return redirect()->route('provinces.index')->with('success', 'Province deleted successfully!');
    }
}
