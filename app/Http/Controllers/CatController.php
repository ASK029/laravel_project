<?php

namespace App\Http\Controllers;

use App\Models\Med;
use Illuminate\Http\Request;
use App\Http\Resources\MedsResource;

class CatController extends Controller
{

    public function getMeds(){
        $meds=Med::get();
        return $meds;
    }

    public function getCats(){
        $cats=Med::select('category')->distinct()->get();
        return $cats;
    }

    public function searchCats($cat){
        $cats=Med::select('category')->where('category', 'LIKE', '%' . $cat . '%')->distinct()->get();
        return $cats;
    }

    public function searchInCat($cat,$med){
        $meds=Med::where('category', 'LIKE', '%' . $cat . '%')->where('commercial_name', 'LIKE', '%' . $med . '%')->get();
        return $meds;
    }

    public function catIndex(Request $request)
    {
        $category = $request->category;
        
        // Get all medicines from the specified category
        $meds = Med::where('category', $category)->get();
        return MedsResource::collection(
            $meds
        );
        // return response()->json(['meds'=>$meds]);
    }

}
