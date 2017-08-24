<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExclusionType;
use App\FormData;

class ExclusionController extends Controller
{
    public function get_new_exclusion(Request $request)
    {
        $exclusion_types   = ExclusionType::all();
        $google_doc_fields = (new FormData)->getFillable();
        
        return view('exclusion.exclusion_add', [
            'exclusion_types'   => $exclusion_types,
            'google_doc_fields' => $google_doc_fields,
        ]);
    }
    
}
