<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoogleDoc extends Model
{
    public static $RANGE = 'A2:Z';
    
    public function __construct()
    {
        $this->doc_range = GoogleDoc::$RANGE;
    }
    
    public function form_data()
    {
        return $this->hasMany(FormData::class);
    }
    
    public function exclusions()
    {
        return $this->hasMany(Exclusions::class, 'exc_google_doc_id');
    }
    
    public function hubspot_form()
    {
        return $this->belongsTo(HubspotForm::class);
    }
}
