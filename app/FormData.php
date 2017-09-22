<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    protected $table = 'form_data';
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'organization',
        'product_file',
        'file_type',
        'release',
        'download_date',
        'google_doc_id',
        'hs_status_code',
        'push_to_hs',
    ];
    
    public function google_doc()
    {
        return $this->belongsTo(GoogleDoc::class);
    }
}
