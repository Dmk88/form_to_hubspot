<?php

namespace App\Http\Controllers;

use App\Exclusions;
use App\ExclusionType;
use App\FormData;
use App\GoogleDoc;
use App\HubspotForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class GoogleDocController extends Controller
{
    public function index(Request $request)
    {
        $google_docs = GoogleDoc::all();
        
        if ($request->ajax()) {
            return Datatables::of($google_docs)->make(true);
        }
        
        return view('google_docs', [
            'google_docs' => $google_docs,
        ]);
    }
    
    public function show(Request $request)
    {
        $google_doc = GoogleDoc::whereId($request->id)->first();
        
        if ($request->ajax()) {
            $start  = $request->has('start_date') ? Carbon::createFromFormat('Y-m-d',
                $request->start_date)->toDateString() : '';
            $end    = $request->has('end_date') ? Carbon::createFromFormat('Y-m-d',
                $request->end_date)->toDateString() : '';
            $result = ($request->has('start_date') && $request->has('end_date')) ? ($google_doc->form_data()->whereBetween('created_at',
                [$start, $end])) : (($request->has('start_date')) ? ($google_doc->form_data()->where('created_at', '>',
                $start)) : (($request->has('start_date')) ? ($google_doc->form_data()->where('created_at', '<',
                $end)) : ''));
            // $google_doc->form_data()->whereBetween('created_at', [$start, $end]);
            // if ($request->has('start_date')) {
            //     $start = Carbon::createFromFormat('Y-m-d', $request->start_date)->toDateString();
            // }
            // $end = Carbon::createFromFormat('Y-m-d', $request->end_date)->toDateString();
            
            return Datatables::of($result)->make(true);
        }
        
        return view('google_doc', [
            'google_doc' => $google_doc,
        ]);
    }
    
    public function show_for_edit(Request $request)
    {
        $google_doc        = GoogleDoc::whereId($request->id)->first();
        $hubspot_forms     = HubspotForm::all();
        $exclusion_types   = ExclusionType::all();
        $google_doc_fields = (new FormData)->getFillable();
        
        return view('google_docs_edit', [
            'google_doc'        => $google_doc,
            'hubspot_forms'     => $hubspot_forms,
            'exclusion_types'   => $exclusion_types,
            'google_doc_fields' => $google_doc_fields,
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
            'doc_id'            => 'required|max:50',
            'doc_name'          => 'max:50',
            'doc_range'         => 'max:10',
            'google_doc_fild.*' => 'max:50',
            'exclusion_value.*' => 'max:100',
        ]);
        $google_doc                  = GoogleDoc::whereId($request->id)->first();
        $google_doc->doc_name        = $request->doc_name;
        $google_doc->doc_id          = $request->doc_id;
        $google_doc->hubspot_form_id = $request->hubspot_form_id;
        $google_doc->doc_range       = $request->doc_range;
        $google_doc->save();
        $google_doc->exclusions()->forceDelete();
        
        if ($request->exclusions) {
            foreach ($request->exclusions['fild'] as $key => $exclusion_doc_field) {
                $exclusion                    = new Exclusions();
                $exclusion->google_doc_field  = $exclusion_doc_field;
                $exclusion->exc_google_doc_id = $request->id;
                $exclusion->value             = $request->exclusions['value'][$key];
                $exclusion->exclusion_type_id = $request->exclusions['type'][$key];
                $exclusion->save();
            }
        }
        
        return redirect('/google_docs');
    }
    
    public function add(Request $request)
    {
        $this->validate($request, [
            'doc_id'            => 'required|max:50',
            'doc_name'          => 'max:50',
            'doc_range'         => 'max:10',
            'google_doc_fild.*' => 'max:50',
            'exclusion_value.*' => 'max:100',
        ]);
        
        $google_doc                  = new GoogleDoc();
        $google_doc->doc_name        = $request->doc_name;
        $google_doc->doc_id          = $request->doc_id;
        $google_doc->doc_range       = $request->doc_range;
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
