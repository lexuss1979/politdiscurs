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
    return view('welcome');
});


Route::get('/articles','ArticleController@index');


/**
 * роутинг
 *
 * / - главная
 * /documents  - документы
 * /documents/id  - документ
 * /magazines  - журналы
 * /magazines/id  - журнал
 * /topic/id -рубрика + фильтры и страницы - ?filter&page
 * /article/id - материал из каталога
 * /search - поиск ?q=
 */
