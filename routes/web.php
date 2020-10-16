<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/category', 'ExpenseCategoriesController@index')->name('category');
Route::get('/category/create', 'ExpenseCategoriesController@create')->name('category.create');
Route::get('/category/edit/{category}', 'ExpenseCategoriesController@edit')->name('category.edit');
Route::patch('/category/{category}', 'ExpenseCategoriesController@update')->name('category.update');
Route::post('/category/store', 'ExpenseCategoriesController@store')->name('category.store');
Route::delete('/category/destroy/{id}', 'ExpenseCategoriesController@destroy')->name('category.destroy');
Route::post('/category/reorder', 'ExpenseCategoriesController@reorder');

Route::get('/expense', 'ExpenseController@index')->name('expense.index');

Route::get('/expense/create', 'ExpenseController@create')->name('expense.create');
Route::get('/expense/create/{id_category}', 'ExpenseController@create')->name('expense.create_with_category');
Route::get('/expense/edit/{expense}', 'ExpenseController@edit')->name('expense.edit');
Route::patch('/expense/{expense}', 'ExpenseController@update')->name('expense.update');
Route::post('/expense/store', 'ExpenseController@store')->name('expense.store');
Route::delete('/expense/destroy/{expense}', 'ExpenseController@destroy')->name('expense.destroy');
Route::get('/expense/graph/sums', 'ExpenseController@getSums')->name('expense.graph.sums');
Route::get('/expense/graph/avg', 'ExpenseController@getAvg')->name('expense.graph.avg');
Route::get('/expense/graph/{year}', 'ExpenseController@sumByYear')->name('expense.graph.year');
Route::get('/expense/graph/{year}/{month}', 'ExpenseController@sumByYearMonth')->name('expense.graph.month');
Route::get('/expense/pie/{year}/{month}', 'ExpenseController@groupByCategory')->name('expense.pie');

Route::get('/expense/search', 'ExpenseController@search')->name('expense.search');

Route::get('/expense/{month}/{year}', 'ExpenseController@index')->name('expense.month');

Route::post('/alerts', 'AlertController@getAlerts')->name('alerts');

Route::get('/user/edit', 'ProfileController@edit')->name('user.edit');
Route::patch('/user/update', 'ProfileController@update')->name('user.update');
Route::post('/user/upload', 'ProfileController@upload')->name('user.avatar.upload');
Auth::routes();

/** Clear Cash From the Browser */
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});