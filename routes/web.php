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

Route::name('404')->get('/404', function () {
    return response()->json(['message' => '没有找到可以访问的页面'], 404);
});
Route::name('401')->get('/401', function () {
    return response()->json(['message' => '未登录，禁止访问。(缺失Accept Header)'], 401);
});
