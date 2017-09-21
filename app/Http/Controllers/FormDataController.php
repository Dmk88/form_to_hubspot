<?php

namespace App\Http\Controllers;

use App\FormData;
use Illuminate\Http\Request;

class FormDataController extends Controller
{
    public function delete(Request $request)
    {
        $form_data = FormData::whereId($request->id)->first();
        
        return $form_data->delete() ? 'success' : 'error';
    }
}
