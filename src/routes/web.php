<?php

Route::group(['prefix' => 'hbl-payment-gateway', 'namespace' => 'Thebikramlama\Hbl\Http\Controllers', 'as' => 'hbl.'], function() {
	Route::get('/', 'HblController@index')->name('index');
	Route::get('error/{type?}', 'HblController@error')->name('error');
});
