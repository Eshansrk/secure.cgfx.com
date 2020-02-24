<?php

/*
|--------------------------------------------------------------------------
| All Routes for Front End
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your NetCoden'S Back End. Just tell NetCoden the URIs it should respond
| to using a Closure or controller method. Build something great!
|
|
|  Designer : NetCoden
|  Developer: NetCoden
|  Maintenance: NetCoden
|  Website: http://netcoden.com
|
*/
Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{

/*=================================
=          Home Page           /
=================================*/

Route::get('/', 'DashboardController@getIndex');

});

// Route::get('/', 'DashboardController@getIndex');




Route::post('/api/3rdParty', 'APIController@registration3rdParty');
Route::get('/api/3rdParty', function(){
	abort(404);
});

Route::get('/api/3rdParty/clients', function(){
	abort(404);
});
Route::post('/api/3rdParty/clients', 'APIController@getAllClients');

Route::get('/api/3rdParty/clients/filter', function(){
	abort(404);
});
Route::post('/api/3rdParty/clients/filter', 'APIController@getAllClientsFilter');

Route::get('/api/3rdParty/client/details', function(){
	abort(404);
});
Route::post('/api/3rdParty/client/details', 'APIController@getClientDetails');

Route::get('/api/3rdParty/client/details/filter', function(){
	abort(404);
});
Route::post('/api/3rdParty/client/details/filter', 'APIController@getClientDetailsFilter');


// test
Route::get('/api/test', 'APIController@test');
Route::get('/api/test1', 'APIController@test1');
Route::get('/api/test2', 'APIController@test2');


/**
 * If you want to add any post route without csrf Include them in VerifyCsrfTOken except list
 */

?>
