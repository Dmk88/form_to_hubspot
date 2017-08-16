<?php

namespace App\Http\Controllers;

use App\GoogleDoc;

class GoogleDocController extends Controller
{
    public function index()
    {
        $google_docs = GoogleDoc::all();
        
        return view('google_docs', [
            'google_docs' => $google_docs,
        ]);
    }
    
}
