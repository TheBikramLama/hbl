<?php

Route::group(['prefix' => 'hbl-payment-gateway', 'namespace' => 'Thebikramlama\Hbl\Http\Controllers', 'as' => 'hbl.'], function() {
	Route::get('error/{type?}', 'HblController@error')->name('error');
	Route::get('/{payment_id?}', 'HblController@index')->name('index');
});
