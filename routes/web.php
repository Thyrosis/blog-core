<?php

use Carbon\Carbon;

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

try {
    App\Setting::routes();
} catch (Exception $e) {
    Route::get('/admin/setting', 'Admin\SettingController@edit')->name('admin.setting.edit')->middleware('auth');
    Route::patch('/admin/setting', 'Admin\SettingController@update')->name('admin.setting.update')->middleware('auth');
    Route::get('/', 'PostController@index')->name('home');
}

/**
 * API ROUTES
 */
Route::group(['prefix' => 'api'], function () {
    Route::get('post/{limit?}', 'Api\PostController@index');
    Route::get('post/{post}', 'Api\PostController@show');
});

/**
 * ADMIN AREA
 */
Route::group(['prefix' => 'admin'], function () {

    Auth::routes();
    Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout');

    Route::get('', 'Admin\PostController@index')->name('admin');

    Route::get('post', 'Admin\PostController@index')->name('admin.post.index');
    Route::get('post/create', 'Admin\PostController@create')->name('admin.post.create');
    Route::post('post/', 'Admin\PostController@store')->name('admin.post.store');
    Route::get('post/{post}/edit', 'Admin\PostController@edit')->name('admin.post.edit');
    Route::patch('post/{post}', 'Admin\PostController@update')->name('admin.post.update');
    Route::delete('post/{post}/delete', 'Admin\PostController@destroy')->name('admin.post.destroy');
    Route::get('post/{post}', 'Admin\PostController@show')->name('admin.post.show');

    Route::get('comment', 'Admin\CommentController@index')->name('admin.comment.index');
    Route::get('comment/{comment}/edit', 'Admin\CommentController@edit')->name('admin.comment.edit');
    Route::patch('comment/{comment}', 'Admin\CommentController@update')->name('admin.comment.update');
    Route::delete('comment/{comment}', 'Admin\CommentController@destroy')->name('admin.comment.destroy');

    Route::get('category', 'Admin\CategoryController@index')->name('admin.category.index');
    Route::post('category', 'Admin\CategoryController@store')->name('admin.category.store');
    Route::patch('category/{category}', 'Admin\CategoryController@update')->name('admin.category.update');
    Route::delete('category/{category}', 'Admin\CategoryController@destroy')->name('admin.category.destroy');

    Route::get('tag', 'Admin\TagController@index')->name('admin.tag.index');
    Route::post('tag', 'Admin\TagController@store')->name('admin.tag.store');
    Route::patch('tag/{tag}', 'Admin\TagController@update')->name('admin.tag.update');
    Route::delete('tag/{tag}', 'Admin\TagController@destroy')->name('admin.tag.destroy');

    Route::get('subscription', 'Admin\SubscriptionController@index')->name('admin.subscription.index');
    Route::post('subscription', 'Admin\SubscriptionController@store')->name('admin.subscription.store');
    Route::get('subscription/{subscription}/edit', 'Admin\SubscriptionController@edit')->name('admin.subscription.edit');
    Route::patch('subscription/{subscription}', 'Admin\SubscriptionController@update')->name('admin.subscription.update');
    Route::delete('subscription', 'Admin\SubscriptionController@destroy')->name('admin.subscription.destroy');
    Route::get('subscription/{subscription}', 'Admin\SubscriptionController@show')->name('admin.subscription.show');

    Route::get('menu', 'Admin\MenuController@edit')->name('admin.menu.index');
    Route::get('menu/edit', 'Admin\MenuController@edit')->name('admin.menu.edit');
    Route::patch('menu/update', 'Admin\MenuController@update')->name('admin.menu.update');
    Route::get('menu/show', 'Admin\MenuController@show')->name('admin.menu.show');

    Route::get('view', 'Admin\ViewController@index')->name('admin.view.index');
    Route::get('view/{view}', 'Admin\ViewController@show')->name('admin.view.show');



});

/**
 * REGULAR VISITOR ROUTES
 */
Route::post('comment', 'CommentController@store')->name('comment.store');

Route::get('category/{category}', 'CategoryController@show')->name('category.show');
Route::get('tag/{tag}', 'TagController@show')->name('tag.show');

Route::post('subscription', 'SubscriptionController@store')->name('subscription.store');
Route::delete('subscription/{subscription}', 'SubscriptionController@destroy')->name('subscription.destroy');

Route::get('search/create', 'SearchController@create')->name('search.create');
Route::post('search', 'SearchController@store')->name('search.store');
Route::get('search/{search}', 'SearchController@show')->name('search.show');

/**
 * MAILCHIMP
 */
Route::post('subscribe', 'MailChimpController@store')->name('newsletter.subscribe');
Route::get('unsubscribe', 'MailChimpController@destroy')->name('newsletter.unsubscribe');
Route::get('subscription', 'MailChimpController@edit')->name('newsletter.edit');
Route::patch('subscription', 'MailChimpController@update')->name('newsletter.patch');
Route::delete('unsubscribe', 'MailChimpController@delete')->name('newsletter.delete');

/**
 * RSS FEED ROUTES
 */
Route::feeds();

/**
 * OTHER ROUTES
 */
App\Form::routes();
App\User::routes();
App\Meta::routes();
// App\Setting::routes();

/**
 * And if we're here, nothing matched. Finally, is it a post??
 */
Route::get('{post}', 'PostController@show')->name('post.show');

// Disabled, no longer relevant
// Route::get('/wp/{wppost}', function ($wppost) {
//     $post = \App\Wppps_post::find($wppost)->loadMissing(['wpcomments', 'wpterms']);
    
//     return $post;
// });

// Route::get('test/mc', function() {
//     $mc = new App\MailChimp;
//     dump(json_decode($mc->getListSubscribers()));
// });