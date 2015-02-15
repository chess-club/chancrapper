<?php

use Chancrapper\Scrape;

Route::get('/', function() {
	$rows = Scrape::orderBy('id', 'desc')->paginate(100);
	return View::make("home", ['rows' => $rows]);
});

Route::get('/view/{id}', function($id) {
	$row = Scrape::find($id);
	return View::make("view", ['row' => $row]);
})->where(['id' => '[0-9]+']);
