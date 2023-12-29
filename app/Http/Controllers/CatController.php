<?php

namespace App\Http\Controllers;

use App\Models\Med;
use Illuminate\Http\Request;

class CatController extends Controller
{
    public function catIndex(Request $request)
    {
        $category = $request->category;
        
        // Get all medicines from the specified category
        $meds = Med::where('category', $category)->select('scientific_name','commercial_name','category','manufacturer_name','price')->get();
        return response()->json(['test'=>$meds]);
    }

}
