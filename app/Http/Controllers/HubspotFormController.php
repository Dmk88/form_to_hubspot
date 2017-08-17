<?php

namespace App\Http\Controllers;

use App\HubspotForm;
use Illuminate\Http\Request;

class HubspotFormController extends Controller
{
    public function index()
    {
        $hubspot_forms = HubspotForm::all();
        
        return view('hubspot_forms', [
            'hubspot_forms' => $hubspot_forms,
        ]);
    }
    
    public function show_for_edit(Request $request)
    {
        $hubspot_form = HubspotForm::whereId($request->id)->first();
        
        return view('hubspot_form_edit', [
            'hubspot_form' => $hubspot_form,
        ]);
    }
    
    public function show_add_form(Request $request)
    {
        return view('hubspot_form_add');
    }
    
    public function edit(Request $request)
    {
        $this->validate($request, [
            'portal_id' => 'required|max:7',
            'form_guid' => 'required|max:50',
            'form_name' => 'max:50',
        ]);
        $hubspot_form            = HubspotForm::whereId($request->id)->first();
        $hubspot_form->form_name = $request->form_name;
        $hubspot_form->portal_id = $request->portal_id;
        $hubspot_form->form_guid = $request->form_guid;
        $hubspot_form->save();
        
        return redirect('/hubspot_forms');
    }
    
    public function add(Request $request)
    {
        $this->validate($request, [
            'portal_id' => 'required|max:7',
            'form_guid' => 'required|max:50',
            'form_name' => 'max:50',
        ]);
        
        $hubspot_form            = new HubspotForm();
        $hubspot_form->form_name = $request->form_name;
        $hubspot_form->portal_id = $request->portal_id;
        $hubspot_form->form_guid = $request->form_guid;
        $hubspot_form->save();
        
        return redirect('/hubspot_forms');
    }
    
    public function delete(Request $request)
    {
        $hubspot_form = HubspotForm::whereId($request->id)->first();
        $hubspot_form->delete();
        
        return redirect('/hubspot_forms');
    }
}
