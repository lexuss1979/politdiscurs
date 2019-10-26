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
Route::get('/content/out','ServiceController@importOut');
Route::get('/content/tt','ServiceController@tt');
Route::get('/content/search','ServiceController@addArticlesToIndex');
Route::get('/content/format','ServiceController@updateContentFormat');
//Route::get('/magazine/import','ServiceController@importMagazines');


/**
 * роутинг
 *  MainPageController
 * / - главная
 */
Route::get('/','MainPageController@index')->name('main');


/**
 *
 *  BookController
 * /books - книги  + фильтры и страницы - ?filter&page
 * /books/id - карточка книги
 */
Route::get('/books/{topic?}','BookController@index');





/**
 *  MagazineController
 * /magazines  - журналы
 * /magazines/id  - журнал
 */
Route::get('/magazines','MagazineController@index')->name('magazines');
Route::get('/magazines/{magazine}','MagazineController@show')->name('magazine-item');

/**
 * TopicController
 * /topic/id -рубрика + фильтры и страницы - ?filter&page
 */
Route::get('/topics/{topic}','TopicController@show')->name('topic');




/**
 * ArticleController
 * /article/id - материал из каталога
 */

Route::get('/articles/{article}','ArticleController@show')->name('articles');

/**
 * FileController
 * /file/id - для pdf
 */

Route::get('/files/{file}','FileController@show');


/**
 * SearchController
 * /search - поиск ?q=
 */
Route::get('/search','SearchController@search')->name('search-results');

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
Route::get('/contributors','StaticContentController@contributors');
Route::get('/partners','StaticContentController@partners');
