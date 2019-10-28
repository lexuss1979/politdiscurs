<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Content common parts
    |--------------------------------------------------------------------------
    |
    |
    */

    'default_H1' =>'Внутренняя политика России и международная политика',
    'default_H2' =>'Онлайн библиотека книг, статей, докладов, документов',

    'articles-per-page' => ENV('ARTICLES_PER_PAGE',10),
    'magazines-per-page' => ENV('MAGAZINES_PER_PAGE',16),
    'magazines-in-more-block' => ENV('MAGAZINES_IN_MORE_BLOCK',100),

    'search-results-per-page' => ENV('SEARCH_RESULTS_PER_PAGE',20),

    'article-default-img' => ENV('ARTICLE_DEFAULT_PLACEHOLDER','/img/layout/item-placeholder.svg'),
    'show-letter-placeholder' => ENV('LETTER_PLACEHOLDER',false),
    'more-article-count' => ENV('MORE_ARTICLE_COUNT',10),
    'books-on-main-page' => ENV('BOOKS_ON_MAIN_PAGE',10),
    'magazines-on-main-page' => ENV('MAGAZINES_ON_MAIN_PAGE',10),


    'static-bg' => ENV('STATIC_BG',true),


];
