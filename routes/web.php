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
});


// Route::get('/google_docs', function () {
//     $google_docs = GoogleDoc::all();
//     // foreach ($google_docs as $google_doc){
//     //     foreach ($google_doc->form_data as $form_d){
//     //         dd($form_d->email);
//     //     }
//     // }
//     // dd($google_docs);
//     // $form_data = FormData::orderBy('created_at', 'asc')->get();
//
//     return view('google_docs', [
//         'google_docs' => $google_docs,
//     ]);
// });

Route::get('/google_docs', 'GoogleDocController@index')->name('google_docs');
Route::post('/google_doc', 'GoogleDocController@store');
Route::delete('/google_doc/{id}', 'GoogleDocController@destroy');

Route::get('/form_data_from_csv/{id}', 'GrabCsvController@index')->name('form_to_hubspot');
