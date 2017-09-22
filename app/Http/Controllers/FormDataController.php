<?php

namespace App\Http\Controllers;

use App\FormData;
use App\GoogleDoc;
use App\HubspotForm;
use Illuminate\Http\Request;

class FormDataController extends Controller
{
    public function delete(Request $request)
    {
        $form_data = FormData::whereId($request->id)->first();
        
        return $form_data->delete() ? 'success' : 'error';
    }
    
    public function pushToHS(Request $request)
    {
        $google_doc      = GoogleDoc::whereId($request->id)->first();
        $form_data_array = $google_doc->form_data()->get();
        $hubspot_form    = $google_doc->hubspot_form()->first();
        
        foreach ($form_data_array as $form_data) {
            $form        = [
                'email'         => $form_data->email,
                'firstname'     => $form_data->first_name,
                'lastname'      => $form_data->last_name,
                'organization'  => $form_data->organization,
                'product_file'  => $form_data->product_file,
                'file_type'     => $form_data->file_type,
                'release'       => $form_data->release,
                'download_date' => $form_data->download_date,
                'hs_persona'    => 'persona_8',
            ];
            $hubspot_req = HubspotForm::pushFormData($hubspot_form->portal_id, $hubspot_form->form_guid, $form);
            
            $form_data->hs_status_code = $hubspot_req;
            $form_data->push_to_hs     = GoogleDoc::$PUSH_TO_HS['PUSHED'];
            $form_data->save();
        }
        
        return redirect('/google_docs');
    }
    
    
}
