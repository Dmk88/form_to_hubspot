<?php

namespace App\Http\Controllers;

use App\GoogleDoc;
use App\HubspotForm;
use Illuminate\Http\Request;

class GoogleDocController extends Controller
{
    public function index()
    {
        $google_docs = GoogleDoc::all();
        
        return view('google_docs', [
            'google_docs' => $google_docs,
        ]);
    }
    
    public function show(Request $request)
    {
        $google_doc = GoogleDoc::whereId($request->id)->first();
        
        return view('google_doc', [
            'google_doc' => $google_doc,
        ]);
    }
    
    public function show_for_edit(Request $request)
    {
        $google_doc    = GoogleDoc::whereId($request->id)->first();
        $hubspot_forms = HubspotForm::all();
        
        return view('google_docs_edit', [
            'google_doc'    => $google_doc,
            'hubspot_forms' => $hubspot_forms,
            'edit'          => 1,
        ]);
    }
    
    public function show_add_form(Request $request)
    {
        $hubspot_forms = HubspotForm::all();
        
        return view('google_docs_add', [
            'hubspot_forms' => $hubspot_forms,
        ]);
    }
    
    public function edit(Request $request)
    {
        $this->validate($request, [
            'doc_id'   => 'required|max:50',
            'doc_name' => 'max:50',
        ]);
        $google_doc                  = GoogleDoc::whereId($request->id)->first();
        $google_doc->doc_name        = $request->doc_name;
        $google_doc->doc_id          = $request->doc_id;
        $google_doc->hubspot_form_id = $request->hubspot_form_id;
        $google_doc->save();
        
        return redirect('/google_docs');
    }
    
    public function add(Request $request)
    {
        $this->validate($request, [
            'doc_id'   => 'required|max:50',
            'doc_name' => 'max:50',
        ]);
        
        $google_doc                  = new GoogleDoc();
        $google_doc->doc_name        = $request->doc_name;
        $google_doc->doc_id          = $request->doc_id;
        $google_doc->hubspot_form_id = $request->hubspot_form_id;
        $google_doc->save();
        
        return redirect('/google_docs');
    }
    
    public function delete(Request $request)
    {
        $google_doc = GoogleDoc::whereId($request->id)->first();
        $google_doc->delete();
        
        return redirect('/google_docs');
    }
}
