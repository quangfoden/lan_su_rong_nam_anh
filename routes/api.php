<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\ContactUsController;
use App\Http\Controllers\API\SettingsController;
use App\Http\Controllers\API\News\CategoryController;
use App\Http\Controllers\API\News\PostController;
use App\Http\Controllers\API\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'admin'], function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum']], function () {

        Route::get('/', function (Request $request) {
            $user = $request->user();
            $user->load([
                'roles' => function ($query) {
                    $query->where('status', 1);
                },
                'roles.permissions' => function ($query) {
                    $query->where('status', 1);
                }
            ]);
            $responseData = [
                'status' => 200,
                'success' => true,
                'message' => 'success',
                'data' => ['user' => $user]
            ];
            return response()->json($responseData);
        });
        Route::get('allusers', [UserController::class, 'allusers'])->middleware('permission:User Manager');
        Route::get('roles', [UserController::class, 'roles'])->middleware('permission:User Manager');
        Route::post('create-new-user', [UserController::class, 'createNewUser'])->middleware('permission:User Manager');
        Route::get('edit/{id}', [UserController::class, 'edit'])->middleware('permission:User Manager');
        Route::post('change-role-user/{id}', [UserController::class, 'changeRoleUser'])->middleware('permission:User Manager');
        Route::post('user-change-password', [UserController::class, 'userChangePassword']);
        Route::post('update', [UserController::class, 'updateUser']);
        Route::get('options', [UserController::class, 'getUserOptions']);
    });

    Route::group(['prefix' => 'role', 'middleware' => ['auth:sanctum']], function () {
        Route::get('all', [UserController::class, 'allRoles'])->middleware('permission:Role Manager');
        Route::post('add', [UserController::class, 'addRole'])->middleware('permission:Role Manager');

        Route::post('update/{id}', [UserController::class, 'updateRole'])->middleware('permission:Role Manager');
        Route::post('update-status/{id}', [UserController::class, 'updateStatusRole'])->middleware('permission:Role Manager');
    });

    Route::group(['prefix' => 'permission', 'middleware' => ['auth:sanctum']], function () {
        Route::get('all', [UserController::class, 'allPermissions'])->middleware('permission:Permission Manager');
        Route::post('add', [UserController::class, 'addPermission'])->middleware('permission:Permission Manager');
        Route::post('update/{id}', [UserController::class, 'updatePermission'])->middleware('permission:Permission Manager');
        Route::post('update-status/{id}', [UserController::class, 'updateStatusPermission'])->middleware('permission:Permission Manager');
    });

    Route::group(['prefix' => 'products', 'middleware' => ['auth:sanctum', 'permission:Products Manager']], function () {
        Route::get('list', [ProductController::class, 'index']);
        Route::get('{id}', [ProductController::class, 'detail']);
        Route::post('store', [ProductController::class, 'store']);
        Route::post('{id}/update', [ProductController::class, 'update']);
    });

    Route::group(['prefix' => 'contact-us', 'middleware' => ['auth:sanctum', 'permission:Contact Manager']], function () {
        Route::get('list', [ContactUsController::class, 'index']);
        Route::get('{id}', [ContactUsController::class, 'detail']);
        Route::post('{id}/change-status', [ContactUsController::class, 'changeStatus']);
    });

    Route::group(['prefix' => 'settings', 'middleware' => ['auth:sanctum', 'permission:Setting Manager']], function () {
        Route::get('list', [SettingsController::class, 'index']);
        Route::post('update', [SettingsController::class, 'update']);
    });

    Route::group(['prefix' => 'category', 'middleware' => ['auth:sanctum', 'permission:News Manager']], function () {
        Route::get('category-opts', [CategoryController::class, 'getCategoryOpts']);
        Route::get('list', [CategoryController::class, 'index']);
        Route::get('{id}', [CategoryController::class, 'detail']);
        Route::post('store', [CategoryController::class, 'store']);
        Route::put('{id}/update', [CategoryController::class, 'update']);
    });

    Route::group(['prefix' => 'post', 'middleware' => ['auth:sanctum', 'permission:News Manager']], function () {
        Route::get('list', [PostController::class, 'index']);
        Route::get('{id}', [PostController::class, 'detail']);
        Route::post('store', [PostController::class, 'store']);
        Route::post('{id}/update', [PostController::class, 'update']);
    });

});

// PUBLIC ROUTERS
Route::get('all-products', [ProductController::class, 'allProducts']);
Route::get('list-ishot', [ProductController::class, 'getProductsIsHot']);
Route::post('send-contact', [ContactUsController::class, 'sendContact']);
Route::get('settings-page', [SettingsController::class, 'getSettingsPage']);
Route::get('all-categories', [CategoryController::class, 'allCategories']);
Route::get('all-posts', [PostController::class, 'allPosts']);
Route::get('latest-posts', [PostController::class, 'latestPosts']);
Route::get('post/{slug}', [PostController::class, 'detailBySlug']);
Route::post('post/like/{id}', [PostController::class, 'likePost']);
