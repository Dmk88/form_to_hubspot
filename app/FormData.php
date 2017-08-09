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
        'google_doc_id',
    ];
}
