<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::latest()->paginate(10);

        return view('admin.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenities.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:amenities,name'],
        ]);

        Amenity::create($data);

        return redirect()
            ->route('admin.amenities.index')
            ->with('success', 'Amenity added successfully!');
    }

    public function edit(Amenity $amenity)
    {
        return view('admin.amenities.edit', compact('amenity'));
    }

    public function update(Request $request, Amenity $amenity)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:amenities,name,' . $amenity->id,
            ],
        ]);

        $amenity->update($data);

        return redirect()
            ->route('admin.amenities.index')
            ->with('success', 'Amenity updated successfully!');
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();

        return redirect()
            ->route('admin.amenities.index')
            ->with('success', 'Amenity deleted successfully!');
    }
}