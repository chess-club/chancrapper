<?php

use Chancrapper\Scrape;

Route::get('/', function() {
	$rows = Scrape::orderBy('id', 'desc')->paginate(100);
	return View::make("listing", ['rows' => $rows]);
});

Route::get('/view/{id}', ['as' => 'view_id', function($id) {
	$row = Scrape::find($id);
	return View::make("view", ['row' => $row]);
}])->where(['id' => '[0-9]+']);

Route::get('/nick/{nick}', ['as' => 'by_nick', function($nick) {
	$rows = Scrape::where('nick', '=', $nick)->orderBy('id', 'desc')->paginate(50);
	return View::make("listing", ['rows' => $rows]);
}])->where(['nick' => '[a-zA-Z0-9\-_\[\]\^|]+']);

Route::get('/chan/{chan}', ['as' => 'by_chan', function($chan) {
	$rows = Scrape::where('chan', '=', '#' . $chan)->orderBy('id', 'desc')->paginate(50);
	return View::make("listing", ['rows' => $rows]);
}])->where(['chan' => '[a-zA-Z0-9\-_]+']);

Route::get('/nicks', ['as' => 'nick_list', function() {
    $rows = Scrape::select('nick', 'id', 'locnam')->groupBy('nick')->orderBy('id', 'desc')->get();
    return View::make("nick_list", ['rows' => $rows]);
}]);
