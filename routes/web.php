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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/', 'AuthController@login')->name('home');
// Route::get('/', function () {
//     return view('login');
// });

// Route::options('/auth', function () {
// });


// Route::get('/', 'AuthController@access');

Route::get('/', function () {
    if (empty(Auth::user())) {
        return redirect('/login');
    }
    
    return redirect('/google_docs');
});

Route::get('/google_docs', 'GoogleDocController@index')->name('google_docs');
// Route::get('/google_doc/{id}', 'GoogleDocController@show');
Route::get('/google_doc/{id}/edit', 'GoogleDocController@show_for_edit');
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


Route::get('/form_data_from_csv/{id}', 'GrabCsvController@index')->name('form_to_hubspot');

// Route::get('/google_docs',['uses'=>'GoogleDocController@index', 'as' => 'datatables']);
Route::get('/google_doc/{id}', ['uses'=>'GoogleDocController@show', 'as' => 'google_doc.form_data']);

// Route::post('/datatables', 'DatatablesController', [
//     'anyData'  => 'datatables.data',
//     'getIndex' => 'datatables',
// ]);
// Route::get('/datatables', 'DatatablesController@anyData')->name('datatables.data');
// Route::get('/datatables', 'DatatablesController@getIndex')->name('datatables');