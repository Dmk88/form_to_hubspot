<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HubspotForm extends Model
{
    public function google_doc()
    {
        return $this->hasMany(GoogleDoc::class);
    }
}
