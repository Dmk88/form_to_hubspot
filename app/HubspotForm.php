<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HubspotForm extends Model
{
    public function google_doc()
    {
        return $this->hasMany(GoogleDoc::class);
    }
    
    public static function pushFormData($portal_id, $form_guid, $form)
    {
        $hubspot_req = \HubSpot::forms()->submit($portal_id, $form_guid, $form);
        
        return $hubspot_req->getStatusCode();
    }
}
