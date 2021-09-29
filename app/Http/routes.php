<?php


Route::group([
    'prefix' => '{lang?}',
], function () {
    Route::group([
        'prefix' => 'back',
    ], function () {

        Route::get('/platform/pages', 'Admin\PlatformController@index');
        Route::get('/platform/update', 'Admin\PlatformController@update');
        Route::any('/upload', 'FileController@upload');
        Route::get('/', 'Admin\DefaultController@index');

        Route::get('/auth/login', 'Auth\CustomAuthController@login');
        Route::post('/auth/login', 'Auth\CustomAuthController@checkLogin');

        Route::get('/auth/register', 'Auth\CustomAuthController@register');
        Route::post('/auth/register', 'Auth\CustomAuthController@checkRegister');

        Route::get('/auth/logout', 'Auth\CustomAuthController@logout');

        Route::any('/{module}/{submenu?}/{action?}/{id?}/{lang_id?}',['uses' => 'RoleManager@routeResponder'] );

    });


    Route::group([], function() {

        Route::post('/orderCall', 'Front\DefaultController@orderCall');
        Route::post('/applyNow', 'Front\DefaultController@applyNow');

        Route::get('/blog', 'Front\BlogController@index');
        Route::get('/blog/search/{keyword}', 'Front\BlogController@getByKeyword');
        Route::get('/blog/{alias}', 'Front\BlogController@article');
        Route::get('/{page}/{page2?}', 'Front\PagesController@getPage');
        Route::get('/', 'Front\PagesController@index');

        Route::post('/post_login', 'Front\UserController@auth');

        Route::group(['middleware' => 'auth_front'], function(){
            // for users
        });

        // temp Route
        // Route::get('/register', 'Front\UserController@register');
        // Route::post('/registerPost', 'Front\UserController@postRegister');

    });

});
