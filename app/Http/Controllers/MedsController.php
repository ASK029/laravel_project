<?php

namespace App\Http\Controllers;

use App\Http\Resources\MedsResource;
use App\Models\Med;
use Hamcrest\Core\IsEqual;
use Illuminate\Http\Request;

class MedsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $meds = Med::search($request->input('search'))->orderBy('id')->get();

        return MedsResource::collection(
            $meds
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'scientific_name' => 'required|string',
            'commercial_name' => 'required|string|unique:meds,commercial_name',
            'category' => 'required|string',
            'manufacturer_name' => 'required|string',
            'price' => 'required|numeric',
            'expiration_date' => 'required|date_format:Y-m-d',
            'quantity_available' => 'required|numeric'
        ]);

        $med = Med::create([
            'scientific_name' => $fields['scientific_name'],
            'commercial_name' => $fields['commercial_name'],
            'category' => $fields['category'],
            'manufacturer_name' => $fields['manufacturer_name'],
            'price' => $fields['price'],
            'expiration_date' => $fields['expiration_date'],
            'quantity_available' => $fields['quantity_available']
        ]);

        return new MedsResource($med);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $med = Med::findOrFail($id);
        return new MedsResource($med);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $med = Med::findOrFail($id);
        $med->update($request->all());

        return new MedsResource($med);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $med = Med::findOrFail($id);
        $med->delete();

        return response(null, 204);
    }
}
