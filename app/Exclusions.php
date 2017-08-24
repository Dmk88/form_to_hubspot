<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exclusions extends Model
{
    public function exclusions_type()
    {
        return $this->belongsTo(ExclusionType::class);
    }
    
    public function google_doc()
    {
        return $this->belongsTo(GoogleDoc::class);
    }
}
