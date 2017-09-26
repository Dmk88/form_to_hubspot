<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    if (empty(Auth::user())) {
        return redirect('/login');
    }
    
    return redirect('/google_docs');
});

Route::get('/google_docs', 'GoogleDocController@index')->name('google_docs');
Route::get('/google_doc/{id}/edit', 'GoogleDocController@show_for_edit');
Route::get('/google_doc/{id}/grab', 'GoogleDocController@grab');
Route::get('/google_doc/grab_all', 'GoogleDocController@grabAll');
Route::post('/google_doc/{id}', 'GoogleDocController@edit');
Route::post('/google_doc', 'GoogleDocController@add');
Route::get('/google_doc', 'GoogleDocController@show_add_form');
Route::delete('/google_doc/{id}', 'GoogleDocController@delete');

Route::get('/hubspot_forms', 'HubspotFormController@index');

Route::get('/hubspot_form/{id}/edit', 'HubspotFormController@show_for_edit');
Route::post('/hubspot_form/{id}', 'HubspotFormController@edit');
Route::post('/hubspot_form', 'HubspotFormController@add');
Route::get('/hubspot_form', 'HubspotFormController@show_add_form');
Route::delete('/hubspot_form/{id}', 'HubspotFormController@delete');

Route::post('/form_data/{id}', ['uses' => 'FormDataController@pushToHS', 'as' => 'form_data.pushToHS']);
Route::get('/form_data/push_all', 'FormDataController@pushToHSAll');
Route::delete('/form_data/{id}', ['uses' => 'FormDataController@delete', 'as' => 'form_data.delete']);

Route::get('/google_doc/{id}', ['uses' => 'GoogleDocController@show', 'as' => 'google_doc.form_data']);
Route::get('/exclusion/get_new_exclusion',
    ['uses' => 'ExclusionController@get_new_exclusion', 'as' => 'exclusion.new_exclusion']);