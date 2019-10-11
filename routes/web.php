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


//Route::get('/articles','ArticleController@index');
//Route::get('/filters/update','ServiceController@updateFilters');
//Route::get('/filters/topics','ServiceController@createTopics');
Route::get('/content/import','ServiceController@importContent');


/**
 * роутинг
 *  MainPageController
 * / - главная
 */
Route::get('/','MainPageController@index');


/**
 *
 *  BookController
 * /books - книги  + фильтры и страницы - ?filter&page
 * /books/id - карточка книги
 */
Route::get('/books','BookController@index');
Route::get('/books/{book}','BookController@show');





/**
 *  MagazineController
 * /magazines  - журналы
 * /magazines/id  - журнал
 */
Route::get('/magazines','MagazineController@index');
Route::get('/magazines/{magazine}','MagazineController@show');

/**
 * TopicController
 * /topic/id -рубрика + фильтры и страницы - ?filter&page
 */
Route::get('/topics/{topic}','TopicController@show');




/**
 * ArticleController
 * /article/id - материал из каталога
 */

Route::get('/articles/{article}','ArticleController@show');

/**
 * FileController
 * /file/id - для pdf
 */

Route::get('/files/{file}','FileController@show');


/**
 * SearchController
 * /search - поиск ?q=
 */
Route::get('/search','SearchController@search');

/**
 * StaticContentController
 * /content - содержание  | статика (нужна генерилка)
 * /about - о проекте  | статика
 * /authors - список авторов  | статика
 * /partners  - партнеры | статика
 *
 */

Route::get('/content','StaticContentController@content');
Route::get('/about','StaticContentController@about');
Route::get('/authors','StaticContentController@authors');
Route::get('/partners','StaticContentController@partners');
