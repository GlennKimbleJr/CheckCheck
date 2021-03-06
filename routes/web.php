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

Route::get('/', function () {
    return redirect()->to(route('checklists.index'));
})->name('home');

Route::resource('checklists', 'ChecklistController')->except(['edit','create']);
Route::resource('checklists.items', 'ChecklistItemsController')->only('store');
Route::put('items/{item}/complete', 'ChecklistItemsController@toggleComplete')->name('checklists.items.complete.toggle');
Route::delete('items/{item}', 'ChecklistItemsController@destroy')->name('checklists.items.destroy');
Route::put('items/{item}', 'ChecklistItemsController@update')->name('checklists.items.update');
