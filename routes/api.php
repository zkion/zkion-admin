<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'm', 'namespace' => 'Manage'], function () {
    Route::post('/login', 'AuthController@login');
    Route::group(['prefix' => 'upload'], function () {
        Route::get('', 'UploadController@index');
        Route::post('', 'UploadController@upload');
    });
    Route::group(['middleware' => ['auth:apm']], function () {
        Route::post('/logout', 'AuthController@logout');
        Route::get('/user', 'AuthController@user');
        Route::group(['prefix' => 'goods'], function () {
//            Route::get('detail', 'GoodsCategoryController@detail');
            Route::get('', 'GoodsController@index');
            Route::post('create', 'GoodsController@store');
//            Route::post('update/{cId}', 'GoodsCategoryController@update');

            Route::group(['prefix' => 'category'], function () {
                Route::get('detail', 'GoodsCategoryController@detail');
                Route::get('query', 'GoodsCategoryController@query');
                Route::post('create', 'GoodsCategoryController@store');
                Route::post('update/{cId}', 'GoodsCategoryController@update');
                Route::post('delete/{cId}', 'GoodsCategoryController@delete');
            });
            Route::group(['prefix' => 'brand'], function () {
                Route::get('', 'GoodsBrandController@index');
//                Route::get('detail', 'GoodsCategoryController@detail');
//                Route::post('create', 'GoodsCategoryController@store');
            });
        });

        Route::group(['prefix' => 'system'], function () {
            Route::group(['prefix' => 'menu'], function () {
                Route::get('', 'MenuController@index');
                Route::post('updateOrCreate', 'MenuController@updateOrCreate');
                Route::post('delete/{mId}', 'MenuController@delete');
                Route::get('detail/{mId}', 'MenuController@detail');
                Route::post('refresh', 'MenuController@refresh');
            });
            Route::group(['prefix' => 'department'], function () {
                Route::get('', 'DepartmentController@index');
                Route::post('updateOrCreate', 'DepartmentController@updateOrCreate');
                Route::get('detail/{id}', 'DepartmentController@detail');
                Route::post('destroy/{id}', 'DepartmentController@destroy');
            });

            Route::group(['prefix' => 'manage'], function () {
                Route::get('', 'ManageController@index');
                Route::post('updateOrCreate', 'ManageController@updateOrCreate');
                Route::get('detail/{id}', 'ManageController@detail');
                Route::post('destroy/{id}', 'ManageController@destroy');
            });
            Route::group(['prefix' => 'role'], function () {
                Route::get('', 'RoleController@index');
                Route::post('updateOrCreate', 'RoleController@updateOrCreate');
                Route::get('detail/{id}', 'RoleController@detail');
                Route::post('destroy/{id}', 'RoleController@destroy');
            });
            Route::group(['prefix' => 'permission'], function () {
                Route::get('', 'PermissionController@index');
                Route::post('updateOrCreate', 'PermissionController@updateOrCreate');
                Route::get('detail/{id}', 'PermissionController@detail');
                Route::post('destroy/{id}', 'PermissionController@destroy');
                Route::get('groups', 'PermissionController@groups');
                Route::get('group/{id}', 'PermissionController@group');
                Route::post('updateGroup', 'PermissionController@updateGroup');
                Route::post('destroyGroup/{id}', 'PermissionController@destroyGroup');
            });
        });
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
