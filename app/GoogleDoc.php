<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoogleDoc extends Model
{
    public function form_data()
    {
        return $this->hasMany(FormData::class);
    }
    
    public function hubspot_form()
    {
        return $this->belongsTo(HubspotForm::class);
    }
}
